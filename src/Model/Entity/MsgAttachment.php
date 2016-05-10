<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MsgAttachment Entity.
 */
class MsgAttachment extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'resource_id' => true,
        'type' => true,
        'msg_id' => true,
        'created_by' => true,
        'created_date' => true,
        'status' => true,
        'resource' => true,
        'msg' => true,
    ];
}
