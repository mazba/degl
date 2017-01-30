<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('users');
        $this->displayField('name_en');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id'
        ]);
        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id'
        ]);
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id'
        ]);
        $this->belongsTo('UserGroups', [
            'foreignKey' => 'user_group_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreatedUser', [
            'className' => 'Users',
            'foreignKey' => 'created_by',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UpdatedUser', [
            'className' => 'Users',
            'foreignKey' => 'updated_by',
            'joinType' => 'LEFT'
        ]);
    $this->addBehavior('FileUpload',['upload_path'=>'users','field'=>'picture']);
//        $this->addBehavior('FileUpload',['upload_path'=>'signature','field'=>'signature']);

//        $this->addBehavior('Josegonzalez/Upload.Upload', [
//            'signature'=> [
//                'path' => 'webroot{DS}img{DS}signature{DS}',
//                'nameCallback'=>function($data,$settings){
//                    return isset($data['name_en']) && $data['name_en'] ? time().'_'.$data['name_en']:'';
//                }
//            ]
//
//        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
            
        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username');
            
        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');
            
        $validator
            ->requirePresence('name_en', 'create')
            ->notEmpty('name_en');
            
        $validator
            ->requirePresence('name_bn', 'create')
            ->notEmpty('name_bn');
            
        $validator
            ->allowEmpty('gender');
            
        $validator
            ->allowEmpty('phone');
            
        $validator
            ->allowEmpty('office_phone');
            
        $validator
            ->allowEmpty('mobile');
            
        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email');
            
        $validator
            ->allowEmpty('national_id_no');
            
        $validator
            ->allowEmpty('present_address');
            
        $validator
            ->allowEmpty('permanent_address');
            
        $validator
            ->allowEmpty('picture');
            
        $validator
            ->add('birth_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('birth_date');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['office_id'], 'Offices'));
        $rules->add($rules->existsIn(['department_id'], 'Departments'));
        $rules->add($rules->existsIn(['designation_id'], 'Designations'));
        $rules->add($rules->existsIn(['user_group_id'], 'UserGroups'));
        return $rules;
    }
}
