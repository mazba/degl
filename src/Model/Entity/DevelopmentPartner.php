<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevelopmentPartner Entity.
 */
class DevelopmentPartner extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'short_code' => true,
        'name_en' => true,
        'name_bn' => true,
        'address' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'ordering' => true,
        'status' => true,
        'projects' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
