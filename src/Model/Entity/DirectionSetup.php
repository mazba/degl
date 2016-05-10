<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DirectionSetup Entity.
 */
class DirectionSetup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'created_date' => true,
        'created_by' => true,
        'status' => true,
        'urgent_type' => true,
        'ordering' => true,
    ];
}
