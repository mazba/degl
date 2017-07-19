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
        'contractor_id' => true,
        'proposed_ra_bill_id' => true,
        'financial_year_estimate_id' => true,
        'security' => true,
        'bill_amount' => true,
        'income_tex' => true,
        'vat' => true,
        'hire_charge' => true,
        'lab_fee' => true,
        'etc_fee' => true,
        'cost_of_material' => true,
        'net_payable' => true,
        'e_field' => true,
        'e_value' => true,
        'status' => true,
        'created_by' => true,
        'created_date' => true,
    ];
}
