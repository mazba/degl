<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Zone Entity.
 */
class Zone extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'division_id' => true,
        'name_en' => true,
        'name_bn' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'division' => true,
        'districts' => true,
        'item_rates' => true,
        'offices' => true,
    ];
}
