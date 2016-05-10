<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recipient Entity.
 */
class Recipient extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'message_register_id' => true,
        'user_id' => true,
        'created_by' => true,
        'created_date' => true,
        'staus' => true,
        'msg_register' => true,
        'user' => true,
    ];
}
