<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkProgramSetup Entity.
 */
class WorkProgramSetup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'item_code' => true,
        'start_date' => true,
        'end_date' => true,
        'remarks' => true,
        'created_date' => true,
        'created_by' => true,
        'status' => true,
        'scheme' => true,
        'scheme_details_id' => true,
    ];
}
