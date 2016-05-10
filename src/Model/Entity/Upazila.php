<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Upazila Entity.
 */
class Upazila extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'lged_syscode' => true,
        'division_id' => true,
        'district_id' => true,
        'lged_code' => true,
        'upazila_geocode' => true,
        'district_name_en' => true,
        'name_bn' => true,
        'name_en' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'division' => true,
        'district' => true,
    ];
}
