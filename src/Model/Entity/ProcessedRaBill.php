<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProcessedRaBill Entity.
 */
class ProcessedRaBill extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'proposed_ra_bill_id' => true,
        'security' => true,
        'income_tex' => true,
        'vat' => true,
        'hire_charge' => true,
        'lab_fee' => true,
        'net_payable' => true,
        'scheme' => true,
        'created_by' => true,
        'created_date' => true,
    ];
}
