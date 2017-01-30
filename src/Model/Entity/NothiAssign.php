<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NothiAssign Entity.
 */
class NothiAssign extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nothi_register_id' => true,
        'receive_file_register_id' => true,
        'scheme_id' => true,
        'project_id' => true,
        'lab_bill_id' => true,
        'hire_charge_id' => true,
        'purto_bill_id' => true,
        'allotment_register_id' => true,
        'nothi_register' => true,
        'receive_file_register' => true,
        'scheme' => true,
        'project' => true,
        'lab_bill' => true,
        'mechanical_bill' => true,
        'purto_bill' => true,
        'allotment_register' => true,
    ];
}
