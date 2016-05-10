<?php
namespace App\Model\Table;

use App\Model\Entity\TreePlant;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TreePlants Model
 */
class TreePlantsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('tree_plants');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('FinancialYearEstimates', [
            'foreignKey' => 'financial_year_estimate_id'
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
            ->add('target_bonoz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('target_bonoz');
            
        $validator
            ->add('target_vesoz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('target_vesoz');
            
        $validator
            ->add('target_foloz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('target_foloz');
            
        $validator
            ->add('target_total_plant', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('target_total_plant');
            
        $validator
            ->add('total_plant_cost', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_plant_cost');
            
        $validator
            ->add('progress_bonoz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('progress_bonoz');
            
        $validator
            ->add('progress_vesoz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('progress_vesoz');
            
        $validator
            ->add('progress_foloz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('progress_foloz');
            
        $validator
            ->add('progress_total_plant', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('progress_total_plant');
            
        $validator
            ->add('road_length', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('road_length');
            
        $validator
            ->add('number_of_instution', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_of_instution');
            
        $validator
            ->add('total_cost', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_cost');
            
        $validator
            ->add('alive_bonoz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('alive_bonoz');
            
        $validator
            ->add('alive_vesoz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('alive_vesoz');
            
        $validator
            ->add('alive_foloz', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('alive_foloz');
            
        $validator
            ->add('alive_total_plant', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('alive_total_plant');
            
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
        $rules->add($rules->existsIn(['financial_year_estimate_id'], 'FinancialYearEstimates'));
        return $rules;
    }
}
