<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity.
 */
class Document extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'document' => true,
        'scheme' => true,
    ];
}
