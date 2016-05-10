<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * District Entity.
 */
class District extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'division_id' => true,
        'zone_id' => true,
        'name_en' => true,
        'name_bn' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'division' => true,
        'zone' => true,
        'municipality' => true,
        'offices' => true,
        'upazila' => true,
    ];
}
