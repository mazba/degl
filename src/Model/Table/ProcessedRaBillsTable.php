<?php
namespace App\Model\Table;

use App\Model\Entity\ProcessedRaBill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProcessedRaBills Model
 */
class ProcessedRaBillsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('processed_ra_bills');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
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

        $this->hasOne('ProcessedReports', [
            'foreignKey' => 'scheme_id',
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
            ->add('security', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('security');
            
        $validator
            ->add('income_tex', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('income_tex');
            
        $validator
            ->add('vat', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('vat');
            
        $validator
            ->add('hire_charge', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('hire_charge');
            
        $validator
            ->add('lab_fee', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lab_fee');
            
        $validator
            ->add('net_payable', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('net_payable');

        $validator
            ->add('cost_of_material', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cost_of_material');

        $validator
            ->add('etc_fee', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('etc_fee');

        $validator
            ->add('e_value', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('e_value');

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
        return $rules;
    }
}
