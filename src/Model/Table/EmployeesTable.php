<?php
namespace App\Model\Table;

use App\Model\Entity\Employee;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 */
class EmployeesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('employees');
        $this->displayField('name_en');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id'
        ]);
        $this->hasMany('AssignVehicles', [
            'foreignKey' => 'employee_id'
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
            ->allowEmpty('employee_no');
            
        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');
            
        $validator
            ->add('joining_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('joining_date');
            
        $validator
            ->add('is_married', 'valid', ['rule' => 'boolean'])
            ->requirePresence('is_married', 'create')
            ->notEmpty('is_married');
            
        $validator
            ->allowEmpty('religion');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['office_id'], 'Offices'));
        $rules->add($rules->existsIn(['designation_id'], 'Designations'));
        return $rules;
    }
}
