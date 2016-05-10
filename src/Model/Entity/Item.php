<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity.
 */
class Item extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'chapter_id' => true,
        'item_display_code' => true,
        'main_code' => true,
        'description' => true,
        'level' => true,
        'unit' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'chapter' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
