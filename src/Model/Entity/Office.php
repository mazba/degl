<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Office Entity.
 */
class Office extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_code' => true,
        'office_short_title' => true,
        'division_id' => true,
        'zone_id' => true,
        'district_id' => true,
        'upazila_id' => true,
        'office_level' => true,
        'name_en' => true,
        'name_bn' => true,
        'office_contact_no' => true,
        'address' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'division' => true,
        'zone' => true,
        'district' => true,
        'upazila' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
