<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Asset Entity.
 */
class Asset extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'asset_code' => true,
        'description' => true,
        'quantity' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
    ];
}
