<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProposedRaBill Entity.
 */
class ProposedRaBill extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'scheme_id' => true,
        'ra_bill_no' => true,
        'total_payable' => true,
        'above_or_less' => true,
        'percentage' => true,
        'bill_amount' => true,
        'measurement_book_id' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'scheme' => true,
        'bill_type' => true,
        'measurement_no' => true,
        'latest_measurement_no' => true,
        'this_bill_amount'=>true
    ];
}
