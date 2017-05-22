<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemePayorder Entity.
 */
class SchemePayorder extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'order_number' => true,
        'initial_date' => true,
        'expire_date' => true,
        'medium' => true,
        'status' => true,
        'submit_date' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'scheme' => true,
    ];
}
