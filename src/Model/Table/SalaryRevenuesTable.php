<?php
namespace App\Model\Table;

use App\Model\Entity\SalaryRevenue;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalaryRevenues Model
 */
class SalaryRevenuesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('salary_revenues');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
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
            ->add('year', 'valid', ['rule' => 'numeric'])
            ->requirePresence('year', 'create')
            ->notEmpty('year');
            
        $validator
            ->add('month', 'valid', ['rule' => 'numeric'])
            ->requirePresence('month', 'create')
            ->notEmpty('month');
            
        $validator
            ->add('bill_pay_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('bill_pay_date', 'create')
            ->notEmpty('bill_pay_date');
            
        $validator
            ->add('basic', 'valid', ['rule' => 'numeric'])
            ->requirePresence('basic', 'create')
            ->notEmpty('basic');
            
        $validator
            ->add('house_rent', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('house_rent');
            
        $validator
            ->add('medical', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('medical');
            
        $validator
            ->add('transport', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('transport');
            
        $validator
            ->add('festival', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('festival');
            
        $validator
            ->add('tiffin', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tiffin');
            
        $validator
            ->add('recreation', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('recreation');
            
        $validator
            ->add('laundry', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('laundry');
            
        $validator
            ->add('overtime', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('overtime');
            
        $validator
            ->add('domestic_aid', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('domestic_aid');
            
        $validator
            ->add('travel', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('travel');
            
        $validator
            ->add('pahari', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pahari');
            
        $validator
            ->add('preshon', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('preshon');
            
        $validator
            ->add('appayon', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('appayon');
            
        $validator
            ->add('education_aid', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('education_aid');
            
        $validator
            ->add('welfare_cut', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('welfare_cut');
            
        $validator
            ->add('other_cut', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('other_cut');
            
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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        return $rules;
    }
}
