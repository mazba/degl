<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdditionalItem Entity.
 */
class AdditionalItem extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'item_display_code' => true,
        'description' => true,
        'unit' => true,
        'rate' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
