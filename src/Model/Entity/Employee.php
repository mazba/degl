<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employee Entity.
 */
class Employee extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'designation_id' => true,
        'father_name' => true,
        'mother_name' => true,
        'name_en' => true,
        'name_bn' => true,
        'gender' => true,
        'phone' => true,
        'office_phone' => true,
        'mobile' => true,
        'email' => true,
        'national_id_no' => true,
        'present_address' => true,
        'permanent_address' => true,
        'picture' => true,
        'birth_date' => true,
        'employee_no' => true,
        'type' => true,
        'joining_date' => true,
        'is_married' => true,
        'religion' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'designation' => true,
        'assign_vehicles' => true,
    ];
}
