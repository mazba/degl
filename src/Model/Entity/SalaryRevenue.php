<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SalaryRevenue Entity.
 */
class SalaryRevenue extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'employee_id' => true,
        'year' => true,
        'month' => true,
        'year_month' => true,
        'bill_pay_date' => true,
        'basic' => true,
        'house_rent' => true,
        'medical' => true,
        'transport' => true,
        'festival' => true,
        'tiffin' => true,
        'recreation' => true,
        'laundry' => true,
        'overtime' => true,
        'domestic_aid' => true,
        'travel' => true,
        'pahari' => true,
        'preshon' => true,
        'appayon' => true,
        'education_aid' => true,
        'welfare_cut' => true,
        'other_cut' => true,
        'total_cut' => true,
        'total_salary' => true,
        'net_salary' => true,
        'remarks' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'employee' => true,
    ];
}
