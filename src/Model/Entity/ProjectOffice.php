<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectOffice Entity.
 */
class ProjectOffice extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'project_id' => true,
        'office_id' => true,
        'financial_year_estimate_id' => true,
        'budget' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'project' => true,
        'office' => true,
        'financial_year_estimate' => true,
    ];
}
