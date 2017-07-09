<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProcessedReport Entity.
 */
class ProcessedReport extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'processed_ra_bill_id' => true,
        'do_commencement' => true,
        'do_completion' => true,
        'edo_completion' => true,
        'ado_completion' => true,
        'status' => true,
        'created_by' => true,
        'scheme' => true,
    ];
}
