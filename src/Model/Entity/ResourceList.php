<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResourceList Entity.
 */
class ResourceList extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'reference_table_name' => true,
    ];
}
