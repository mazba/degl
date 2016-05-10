<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabBillDetail Entity.
 */
class LabBillDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'lab_bill_id' => true,
        'lab_actual_test_id' => true,
        'lab_bill' => true,
        'lab_actual_test' => true,
    ];
}
