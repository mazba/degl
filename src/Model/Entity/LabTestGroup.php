<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabTestGroup Entity.
 */
class LabTestGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name_en' => true,
        'name_bn' => true,
        'created_date' => true,
        'created_by' => true,
        'updated_date' => true,
        'updated_by' => true,
        'status' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
