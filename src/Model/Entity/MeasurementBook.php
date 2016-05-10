<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MeasurementBook Entity.
 */
class MeasurementBook extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'scheme_id' => true,
        'contractor_id' => true,
        'work_status' => true,
        'work_commencement_date' => true,
        'work_completion_date' => true,
        'book_no' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'scheme' => true,
        'contractor' => true,
    ];
}
