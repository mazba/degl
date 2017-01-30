<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FineAdjustment Entity.
 */
class FineAdjustment extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'economic_code' => true,
        'adjusted_amount' => true,
        'reason' => true,
        'created_date' => true,
        'created_by' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'scheme' => true,
    ];
}
