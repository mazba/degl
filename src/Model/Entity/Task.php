<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity.
 */
class Task extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'component_id' => true,
        'module_id' => true,
        'name_en' => true,
        'name_bn' => true,
        'description' => true,
        'icon' => true,
        'controller' => true,
        'ordering' => true,
        'position_left' => true,
        'position_top' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'component' => true,
        'module' => true,
    ];
}
