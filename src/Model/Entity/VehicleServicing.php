<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VehicleServicing Entity.
 */
class VehicleServicing extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'vehicle_id' => true,
        'financial_year_estimate_id' => true,
        'breakdown_date' => true,
        'km_hr' => true,
        'is_periodic_maintenance' => true,
        'defects' => true,
        'servicing_start_date' => true,
        'servicing_end_date' => true,
        'job_card' => true,
        'service_charge' => true,
        'service_charge_approved' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'other_charge' => true,
        'status' => true,
        'office' => true,
        'vehicle' => true,
    ];
}
