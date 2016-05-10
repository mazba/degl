<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contractor Entity.
 */
class Contractor extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'contractor_class_title' => true,
        'contractor_title' => true,
        'contact_person_name' => true,
        'contractor_phone' => true,
        'contractor_email' => true,
        'contractor_address' => true,
        'mobile' => true,
        'fax' => true,
        'vat_no' => true,
        'tin_no' => true,
        'trade_licence_no' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
    ];
}
