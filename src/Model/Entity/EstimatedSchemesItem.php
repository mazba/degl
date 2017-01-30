<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EstimatedSchemesItem Entity.
 */
class EstimatedSchemesItem extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'item_display_code' => true,
        'description' => true,
        'unit' => true,
        'rate' => true,
        'quantity' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'scheme' => true,
    ];
}
