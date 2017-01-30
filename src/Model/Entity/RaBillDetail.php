<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RaBillDetail Entity.
 */
class RaBillDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'ra_bill_id' => true,
        'scheme_item_id' => true,
        'short_description' => true,
        'serial_number' => true,
        'ra_bill' => true,
        'scheme_item' => true,
    ];
}
