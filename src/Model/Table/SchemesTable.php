<?php
namespace App\Model\Table;

use App\Model\Entity\Scheme;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Schemes Model
 */
class SchemesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('schemes');
        $this->displayField('name_en');
        $this->primaryKey('id');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Packages', [
            'foreignKey' => 'package_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WorkTypes', [
            'foreignKey' => 'work_type_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('WorkSubTypes', [
            'foreignKey' => 'work_sub_type_id'
        ]);
        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id',
        ]);
        $this->belongsTo('Upazilas', [
            'foreignKey' => 'upazila_id'
        ]);
        $this->belongsTo('Municipalities', [
            'foreignKey' => 'municipality_id'
        ]);
        $this->belongsTo('FinancialYearEstimates', [
            'foreignKey' => 'financial_year_estimate_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ReceiveFileRegisters', [
            'foreignKey' => 'scheme_id'
        ]);
        $this->hasMany('multimedia', [
            'foreignKey' => 'scheme_id'
        ]);
        $this->hasMany('SchemeDetails', [
            'foreignKey' => 'scheme_id'
        ]);

        $this->hasOne('VehiclesStatus', [
            'foreignKey' => 'scheme_id'
        ]);

        $this->hasOne('ProposedRaBills', [
            'foreignKey' => 'scheme_id'
        ]);

        $this->hasMany('SchemeProgresses', [
            'foreignKey' => 'scheme_id'
        ]);

        $this->hasMany('SchemeContractors', [
            'foreignKey' => 'scheme_id'
        ]);

        $this->hasMany('SchemeProgressPlans', [
            'foreignKey' => 'scheme_id'
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
        $this->belongsTo('SchemeTypes', [
            'foreignKey' => 'scheme_type_id'
        ]);
        $this->belongsTo('SubSchemeTypes', [
            'foreignKey' => 'sub_scheme_type_id'
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
            ->requirePresence('scheme_code', 'create')
            ->notEmpty('scheme_code');
            
        /*$validator
            ->requirePresence('roadid', 'create')
            ->notEmpty('roadid');*/
            
        $validator
            ->add('pic_flag', 'valid', ['rule' => 'numeric'])
            ->requirePresence('pic_flag', 'create')
            ->notEmpty('pic_flag');
            
        $validator
            ->requirePresence('name_en', 'create')
            ->notEmpty('name_en');
            
        $validator
            ->requirePresence('name_bn', 'create')
            ->notEmpty('name_bn');
            
        $validator
            ->add('proposed_start_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('proposed_start_date');
            
        $validator
            ->add('actual_start_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('actual_start_date');

        $validator
            ->add('tender_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tender_date');

        $validator
            ->add('contract_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('contract_date');

        $validator
            ->add('expected_complete_date', 'valid', ['rule' => 'numeric'])

            ->allowEmpty('expected_complete_date');

        $validator
            ->add('actual_complete_date', 'valid', ['rule' => 'numeric'])

            ->allowEmpty('actual_complete_date');
            
        $validator
            ->add('post_work_change', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('post_work_change');
            
        $validator
            ->add('revised', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('revised');
            
        $validator
            ->add('approved', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('approved');
            
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
        $rules->add($rules->isUnique(['scheme_code']));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['package_id'], 'Packages'));
        $rules->add($rules->existsIn(['work_type_id'], 'WorkTypes'));
        $rules->add($rules->existsIn(['work_sub_type_id'], 'WorkSubTypes'));
        $rules->add($rules->existsIn(['district_id'], 'Districts'));
        $rules->add($rules->existsIn(['upazila_id'], 'Upazilas'));
        $rules->add($rules->existsIn(['municipality_id'], 'Municipalities'));
        $rules->add($rules->existsIn(['financial_year_estimate_id'], 'FinancialYearEstimates'));
        return $rules;
    }
}
