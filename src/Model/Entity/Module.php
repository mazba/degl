<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Module Entity.
 */
class Module extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'component_id' => true,
        'name_en' => true,
        'name_bn' => true,
        'icon' => true,
        'description' => true,
        'ordering' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'component' => true,
    ];
}
