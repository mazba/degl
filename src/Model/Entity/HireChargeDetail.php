<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HireChargeDetail Entity.
 */
class HireChargeDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'hire_charge_id' => true,
        'item_code' => true,
        'quantity' => true,
        'item_total' => true,
        'status' => true,
        'created_by' => true,
        'created_date' => true,
        'hire_charge' => true,
    ];
}
