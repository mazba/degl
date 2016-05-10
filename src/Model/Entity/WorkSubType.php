<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkSubType Entity.
 */
class WorkSubType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'work_type_id' => true,
        'short_title' => true,
        'title' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'work_type' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
