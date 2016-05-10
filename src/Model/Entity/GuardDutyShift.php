<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GuardDutyShift Entity.
 */
class GuardDutyShift extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'name' => true,
        'start_time' => true,
        'end_time' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
