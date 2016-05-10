<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FinancialYearEstimate Entity.
 */
class FinancialYearEstimate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
