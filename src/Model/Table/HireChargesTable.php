<?php
namespace App\Model\Table;

use App\Model\Entity\HireCharge;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HireCharges Model
 */
class HireChargesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('hire_charges');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FinancialYearEstimates', [
            'foreignKey' => 'financial_year_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('HireChargeDetails', [
            'foreignKey' => 'hire_charge_id'
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
            
//        $validator
//            ->add('total_amount', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('total_amount', 'create')
//            ->notEmpty('total_amount');
//
//        $validator
//            ->add('created_by', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('created_by', 'create')
//            ->notEmpty('created_by');
//
//        $validator
//            ->add('created_date', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('created_date', 'create')
//            ->notEmpty('created_date');
//
//        $validator
//            ->add('updated_by', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('updated_by', 'create')
//            ->notEmpty('updated_by');
//
//        $validator
//            ->add('updated_date', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('updated_date', 'create')
//            ->notEmpty('updated_date');
//
//        $validator
//            ->add('status', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));
//        $rules->add($rules->isUnique(['scheme_id'], 'Contractors'));
        return $rules;
    }
}
