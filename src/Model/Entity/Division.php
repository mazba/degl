<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Division Entity.
 */
class Division extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name_en' => true,
        'name_bn' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'districts' => true,
        'offices' => true,
        'upazila' => true,
        'zones' => true,
    ];
}
