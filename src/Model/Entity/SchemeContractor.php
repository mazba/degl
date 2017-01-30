<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemeContractor Entity.
 */
class SchemeContractor extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'contractor_id' => true,
        'is_lead' => true,
        'status' => true,
        'scheme' => true,
        'contractor' => true,
    ];
}
