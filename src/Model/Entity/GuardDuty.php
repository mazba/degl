<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GuardDuty Entity.
 */
class GuardDuty extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'employee_id' => true,
        'guard_duty_shift_id' => true,
        'duty_date' =>true,
        'location' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'employee' => true,
        'guard_duty_shift' => true,
    ];
}
