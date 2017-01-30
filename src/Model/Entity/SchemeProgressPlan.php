<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemeProgressPlan Entity.
 */
class SchemeProgressPlan extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'progress' => true,
        'date' => true,
        'created_date' => true,
        'scheme' => true,
    ];
}
