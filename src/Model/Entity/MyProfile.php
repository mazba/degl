<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyProfile Entity.
 */
class MyProfile extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'name_en' => true,
        'name_bn' => true,
        'gender' => true,
        'phone' => true,
        'office_phone' => true,
        'mobile' => true,
        'email' => true,
        'national_id_no' => true,
        'present_address' => true,
        'permanent_address' => true,
        'picture' => true,
        'birth_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
    protected function _setPassword($value)
    {
        //$hasher = new DefaultPasswordHasher();
        //return $hasher->hash($value);
        return md5($value);
    }
}
