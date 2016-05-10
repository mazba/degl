<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemeType Entity.
 */
class SchemeType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'status' => true,
        'updated_by' => true,
        'updated_date' => true,
        'created_by' => true,
        'created_date' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
