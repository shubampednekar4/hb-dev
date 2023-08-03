<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\IdentifierInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authentication\UrlChecker\DefaultUrlChecker;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Exception\MissingIdentityException;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\HttpsEnforcerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;
use DateTime;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
            $this->addPlugin('IdeHelper');
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            Configure::write('DebugKit.ignoreAuthorization', true);
            Configure::write('DebugKit.forceEnable', true);
            $this->addPlugin('DebugKit');
        }

        // Load more plugins here
        $this->addPlugin('Authorization');
        $this->addPlugin('Search');
        $this->addPlugin('MaterialBake');
        $this->addPlugin('Authentication');
        $this->addPlugin('Modern');
        $this->addPlugin('Migrations');
        $this->addPlugin('CakeDto');
        $this->addPlugin('CakePdf');
        $this->addPlugin('Queue');
        $this->addPlugin('Dashboard');
        $this->addPlugin('BootstrapUI');
    }

    /**
     * Bootrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }
        $this->addPlugin('Migrations');

        // Load more plugins here
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $csrf = new CsrfProtectionMiddleware([
                'httponly' => true,
            ]);
        $csrf->skipCheckCallback(function ($request) {
            if ($request->getParam('action') === 'sendOrderEmail') {
                return true;
            }
            if ($request->getParam('controller') === 'pages') {
                return true;
            }
        });
        $routing = new RoutingMiddleware($this);


        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add($routing)

            // Parse various types of encoded request bodies so that they are
            // available as array through $request->getData()
            // https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
            ->add(new BodyParserMiddleware())
            ->add(new EncryptedCookieMiddleware(
                ['hb_cookieAuth','secrets', 'protected'],
                Configure::read('Security.cookieKey')
            ))
            ->add(new AuthenticationMiddleware($this))
            ->add(new AuthorizationMiddleware($this, [
                'identityDecorator' => function ($auth, $user) {
                    return $user->setAuthorization($auth);
                },
                'unauthorizedHandler' => [
                    'className' => 'Authorization.Redirect',
                    'url' => '/users/login',
                    'queryParam' => 'redirectUrl',
                    'exceptions' => [
                        MissingIdentityException::class,
                    ],
                ],
            ]))
            ->add($csrf)
            ->add(new HttpsEnforcerMiddleware([
                'redirect' => true,
                'statusCode' => 302,
                'headers' => ['X-Https-Upgrade' => 1],
            ]));

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        $service->setConfig([
            'unauthenticatedRedirect' => '/users/login',
            'queryParam' => 'redirect',
        ]);

        $fields = [
            IdentifierInterface::CREDENTIAL_USERNAME => 'login',
            IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
        ];
        $loginUrl = '/users/login';

        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => ['user_email', 'user_username'],
                IdentifierInterface::CREDENTIAL_PASSWORD => 'user_password',
            ],
        ]);
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => $loginUrl,
        ]);
        $service->loadAuthenticator('Authentication.Cookie', [
            'rememberMeField' => 'remember_me',
            'cookie' => [
                'name' => 'hb_cookieAuth',
                'expires' => new DateTime('+1 year'),
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => false,
                'value' => '',
            ],
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => 'user_username',
                IdentifierInterface::CREDENTIAL_PASSWORD => 'user_password',
            ],
            'urlChecker' => DefaultUrlChecker::class,
            'loginUrl' => $loginUrl,
            'passwordHasher' => DefaultPasswordHasher::class,
        ]);
        $service->loadAuthenticator('Authentication.Session');

        return $service;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();

        return new AuthorizationService($resolver);
    }

    public function routes(RouteBuilder $routes): void
    {
        $options = [

        ];

        $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware($options));
        parent::routes($routes);
    }
}
