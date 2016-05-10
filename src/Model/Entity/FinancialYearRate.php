<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FinancialYearRate Entity.
 */
class FinancialYearRate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'financial_year_estimate_id' => true,
        'rate_month' => true,
        'irl_tag' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'financial_year_estimate' => true,
        'item_rates' => true,
        'schemes' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
