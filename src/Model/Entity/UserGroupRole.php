<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserGroupRole Entity.
 */
class UserGroupRole extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'user_group_id' => true,
        'component_id' => true,
        'module_id' => true,
        'task_id' => true,
        'task_index' => true,
        'task_view' => true,
        'task_add' => true,
        'task_edit' => true,
        'task_delete' => true,
        'task_report' => true,
        'task_print' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'user_group' => true,
        'component' => true,
        'module' => true,
        'task' => true,
    ];
}
