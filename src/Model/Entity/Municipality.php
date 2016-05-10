<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Municipality Entity.
 */
class Municipality extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'lged_code' => true,
        'district_id' => true,
        'name_bn' => true,
        'name_en' => true,
        'class' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'district' => true,
        'schemes' => true,
    ];
}
