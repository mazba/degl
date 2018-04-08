<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipmentRevenue Entity.
 */
class EquipmentRevenue extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'financial_year_estimate_id' => true,
        'month' => true,
        'income' => true,
        'expense' => true,
        'status' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'financial_year_estimate' => true,
    ];
}
