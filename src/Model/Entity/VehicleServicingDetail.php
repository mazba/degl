<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VehicleServicingDetail Entity.
 */
class VehicleServicingDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'vehicle_servicing_id' => true,
        'name' => true,
        'quantity' => true,
        'rate' => true,
        'total' => true,
        'created_date' => true,
        'created_by' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'vehicle_servicing' => true,
    ];
}
