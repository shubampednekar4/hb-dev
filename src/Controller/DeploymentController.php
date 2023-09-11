<?php
// src/Controller/DeploymentController.php

// src/Controller/DeploymentController.php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Http\Response;
use Symfony\Component\Process\Process;
use Authorization\Exception\AuthorizationRequiredException;
use Cake\Controller\Component\AuthorizationComponent;

class DeploymentController extends AppController
{
    public function dep(): Response
    {
        try {
            
            // Bypass authorization check for this action
            $this->Authorization->skipAuthorization();
            
             $identity = $this->Authentication->getIdentity();
             $identifier = $identity->getIdentifier();

            // Get the path to the deploy_script.sh script in the root directory
            $scriptPath = __DIR__ . '/../../deploy_script.sh'; // Adjust the path as needed

            // Create a new Process instance
            $process = new Process([$scriptPath]);

            // Run the process and capture the output
            $process->run();

            // Get the process output
            $output = $process->getOutput();

            // Customize the response as needed
            $response = $this->response->withStringBody($output);
            
            // Customize the response as needed
            $successMessage = "Deployment script executed successfully:\n" . $output;
            $response = $this->response->withStringBody($successMessage);


            return $response;
        } catch (AuthorizationRequiredException $e) {
            // Handle the exception, for example, by logging the error and providing a user-friendly message
            $errorMessage = "Deployment failed due to authorization issue.";
            $this->log($errorMessage, 'error');

            // Create a response indicating the error to the user
            $response = $this->response->withStatus(403); // Forbidden status code
            $response = $response->withStringBody($errorMessage);

            return $response;
        }
    }
}
