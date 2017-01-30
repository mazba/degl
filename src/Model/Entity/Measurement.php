<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Measurement Entity.
 */
class Measurement extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'measurement_no' => true,
        'measurement_date' => true,
        'measured-by' => true,
        'item_id' => true,
        'quantity_of_work_done' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'scheme' => true,
        'item' => true,
    ];
}
