<?php
namespace App\Model\Table;

use App\Model\Entity\PurtoBill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurtoBills Model
 */
class PurtoBillsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('purto_bills');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FinancialYearEstimates', [
            'foreignKey' => 'financial_year_estimate_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
            'joinType' => 'INNER'
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
            ->requirePresence('bill_type', 'create')
            ->notEmpty('bill_type');
            
        $validator
            ->add('gross_bill', 'valid', ['rule' => 'numeric'])
            ->requirePresence('gross_bill', 'create')
            ->notEmpty('gross_bill');
            
        $validator
            ->add('security', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('security');
            
        $validator
            ->add('vat', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('vat');
            
        $validator
            ->add('income_taxes', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('income_taxes');
            
        $validator
            ->add('roller_charge', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('roller_charge');
            
        $validator
            ->add('lab_fee', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lab_fee');
            
        $validator
            ->add('fine', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fine');
            
        $validator
            ->add('net_taka', 'valid', ['rule' => 'numeric'])
            ->requirePresence('net_taka', 'create')
            ->notEmpty('net_taka');
            
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
        $rules->add($rules->existsIn(['financial_year_estimate_id'], 'FinancialYearEstimates'));
        $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
