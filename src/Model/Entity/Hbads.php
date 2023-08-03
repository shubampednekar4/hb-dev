<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Hbads extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected $_primaryKey = 'hbad_id';

    protected $_table = 'hbads';
}
