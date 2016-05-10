<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchemeDetail Entity.
 */
class SchemeDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'item_id' => true,
        'scheme_status' => true,
        'comp_serial_no' => true,
        'deducation' => true,
        'component_location' => true,
        'cl_length' => true,
        'cl_width' => true,
        'cl_height_depth' => true,
        'cl_area_volume' => true,
        'item_quantity' => true,
        'has_breakup' => true,
        'remarks' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'scheme' => true,
        'item' => true,
        'details' => true,
    ];
}
