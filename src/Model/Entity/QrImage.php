<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QrImage Entity.
 */
class QrImage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'qr_image' => true,
        'scheme' => true,
    ];
}
