<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Scheme Entity.
 */
class Scheme extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,

    ];
}