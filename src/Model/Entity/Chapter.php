<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chapter Entity.
 */
class Chapter extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'parent' => true,
        'chapter_code' => true,
        'name' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
