<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VehiclesStatus Entity.
 */
class VehiclesStatus extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'vehicle_id' => true,
        'employee_id' => true,
        'scheme_id' => true,
        'vehicle_location' => true,
        'remark' => true,
        'assign_date' => true,
        'end_date' => true,
        'status' => true,
        'vehicle' => true,
        'employee' => true,
        'scheme' => true,
    ];
}
