<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabTestFrequency Entity.
 */
class LabTestFrequency extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'lab_test_group_id' => true,
        'lab_test_list_id' => true,
        'test_no' => true,
        'test_no_type' => true,
        'per_unit' => true,
        'unit_type' => true,
        'created_date' => true,
        'created_by' => true,
        'updated_date' => true,
        'updated_by' => true,
        'status' => true,
        'lab_test_list' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
