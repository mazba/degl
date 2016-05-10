<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserGroup Entity.
 */
class UserGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name_en' => true,
        'name_bn' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'ordering' => true,
        'status' => true,
        'users' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
