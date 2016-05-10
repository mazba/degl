<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemeProgress Entity.
 */
class SchemeProgress extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'office_id' => true,
        'progress_value' => true,
        'remarks' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'scheme' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
