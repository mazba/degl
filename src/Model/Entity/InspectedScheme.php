<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InspectedScheme Entity.
 */
class InspectedScheme extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'inspection_id' => true,
        'scheme_id' => true,
        'status1' => true,
        'status2' => true,
        'remarks1' => true,
        'remarks2' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'inspection' => true,
        'scheme' => true,
    ];
}
