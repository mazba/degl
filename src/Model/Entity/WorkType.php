<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkType Entity.
 */
class WorkType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'short_title' => true,
        'title' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'work_sub_types' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
