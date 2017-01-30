<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReturnedSecurity Entity.
 */
class ReturnedSecurity extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'returned_amount' => true,
        'created_date' => true,
        'created_by' => true,
        'updated_date' => true,
        'updated_by' => true,
        'status' => true,
        'scheme' => true,
    ];
}
