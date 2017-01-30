<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NoteSheetEntry Entity.
 */
class NoteSheetEntry extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'entry_serial_no' => true,
        'entry_definition_id' => true,
        'view_scope' => true,
        'attachments' => true,
        'text' => true,
        'approval_sequence' => true,
        'approval_status' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'scheme' => true,
    ];
}
