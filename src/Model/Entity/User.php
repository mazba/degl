<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'office_id' => true,
        'department_id' => true,
        'designation_id' => true,
        'username' => true,
        'password' => true,
        'name_en' => true,
        'name_bn' => true,
        'user_group_id' => true,
        'gender' => true,
        'phone' => true,
        'office_phone' => true,
        'mobile' => true,
        'email' => true,
        'national_id_no' => true,
        'present_address' => true,
        'permanent_address' => true,
        'signature' => true,
        'picture' => true,
        'birth_date' => true,
        'created_by' => true,
        'created_date' => true,
        'updated_by' => true,
        'updated_date' => true,
        'status' => true,
        'office' => true,
        'designation' => true,
        'user_group' => true,
        'created_user' => true,
        'tokenhash' => true,
        'updated_user' => true,
    ];
    protected function _setPassword($value)
    {
        //$hasher = new DefaultPasswordHasher();
        //return $hasher->hash($value);
        return md5($value);
    }
}
