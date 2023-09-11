<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Newsletters extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected $_primaryKey = 'newsletter_id';

    protected $_table = 'newsletters';
}
