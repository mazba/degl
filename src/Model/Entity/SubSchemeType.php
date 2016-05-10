<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubSchemeType Entity.
 */
class SubSchemeType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_type_id' => true,
        'title' => true,
        'status' => true,
        'created_by' => true,
        'updated_by' => true,
        'updated_date' => true,
        'created_date' => true,
        'scheme_type' => true,
    ];
}
