<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MechanicalBillTracker Entity.
 */
class MechanicalBillTracker extends Entity
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
