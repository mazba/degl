<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LetterApproval Entity.
 */
class LetterApproval extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'receive_file_register_id' => true,
        'user_id' => true,
        'receive_file_register' => true,
        'user' => true,
        'created_date' => true,
    ];
}
