<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity.
 */
class File extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'file_path' => true,
        'file_label' => true,
        'table_name' => true,
        'table_key' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
    ];
}
