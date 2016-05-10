<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssignVehicle Entity.
 */
class AssignVehicle extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'vehicle_id' => true,
        'employee_id' => true,
        'assign_date' => true,
        'end_date' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'vehicle' => true,
        'employee' => true,
    ];
}
