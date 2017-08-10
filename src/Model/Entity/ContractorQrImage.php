<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractorQrImage Entity.
 */
class ContractorQrImage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'contractor_id' => true,
        'qr_image' => true,
    ];
}
