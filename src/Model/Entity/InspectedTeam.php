<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InspectedTeam Entity.
 */
class InspectedTeam extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name_en' => true,
        'name_bn' => true,
        'status' => true,
        'created_by' => true,
        'created_date' => true,
        'inspections' => true,
    ];
}
