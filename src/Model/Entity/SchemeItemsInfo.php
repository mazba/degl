<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemeItemsInfo Entity.
 */
class SchemeItemsInfo extends Entity
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
        'status' => true,
    ];
}
