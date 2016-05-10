<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WageRegister Entity.
 */
class WageRegister extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'employee_id' => true,
        'billing_days' => true,
        'daily_wage_rate' => true,
        'total_wage' => true,
        'bill_no' => true,
        'bill_pay_date' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'employee' => true,
        'wage_months' => true,
    ];
}
