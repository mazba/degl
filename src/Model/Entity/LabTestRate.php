<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabTestRate Entity.
 */
class LabTestRate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'lab_test_list_id' => true,
        'financial_year_estimate_id' => true,
        'rate' => true,
        'status' => true,
        'created_date' => true,
        'created_by' => true,
        'lab_test_list' => true,
        'financial_year_estimate' => true,
    ];
}
