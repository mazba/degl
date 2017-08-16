<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectIncomeExpense Entity.
 */
class ProjectIncomeExpense extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'project_id' => true,
        'receive_money' => true,
        'expense_money' => true,
        'unpaid_money' => true,
        'month' => true,
        'year' => true,
        'status' => true,
        'created_by' => true,
        'project' => true,
    ];
}
