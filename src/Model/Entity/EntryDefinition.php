<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EntryDefinition Entity.
 */
class EntryDefinition extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'view_scope' => true,
        'attachments' => true,
        'creation_permission' => true,
        'approval_sequence' => true,
        'preconditions' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
    ];
}
