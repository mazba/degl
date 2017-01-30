<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NoteSheetEvent Entity.
 */
class NoteSheetEvent extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'note_sheet_entry_id' => true,
        'recipient_designation_id' => true,
        'office_id' => true,
        'is_read' => true,
        'scheme' => true,
        'note_sheet_entry' => true,
        'office' => true,
    ];
}
