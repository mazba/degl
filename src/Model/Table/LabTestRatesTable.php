<?php
namespace App\Model\Table;

use App\Model\Entity\LabTestRate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabTestRates Model
 */
class LabTestRatesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('lab_test_rates');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('LabTestLists', [
            'foreignKey' => 'lab_test_list_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FinancialYearEstimates', [
            'foreignKey' => 'financial_year_estimate_id',
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
            ->add('rate', 'valid', ['rule' => 'numeric'])
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');
            
        $validator
            ->add('status', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('status');
            
        $validator
            ->add('created_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_date', 'create')
            ->notEmpty('created_date');
            
        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

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
        $rules->add($rules->isUnique(['lab_test_list_id','financial_year_estimate_id']));
        $rules->add($rules->existsIn(['lab_test_list_id'], 'LabTestLists'));
        $rules->add($rules->existsIn(['financial_year_estimate_id'], 'FinancialYearEstimates'));
        return $rules;
    }
}
