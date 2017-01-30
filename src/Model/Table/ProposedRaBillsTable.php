<?php
namespace App\Model\Table;

use App\Model\Entity\ProposedRaBill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProposedRaBills Model
 */
class ProposedRaBillsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('proposed_ra_bills');
        $this->displayField('ra_bill_no');
        $this->primaryKey('id');

        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
            'joinType' => 'INNER'
        ]);
//        $this->belongsTo('MeasurementBooks', [
//            'foreignKey' => 'measurement_book_id',
//            'joinType' => 'INNER'
//        ]);
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
            ->requirePresence('ra_bill_no', 'create')
            ->notEmpty('ra_bill_no');
            
        $validator
            ->add('total_payable', 'valid', ['rule' => 'numeric'])
            ->requirePresence('total_payable', 'create')
            ->notEmpty('total_payable');
            
        $validator
            ->requirePresence('above_or_less', 'create')
            ->notEmpty('above_or_less');
            
        $validator
            ->add('percentage', 'valid', ['rule' => 'numeric'])
            ->requirePresence('percentage', 'create')
            ->notEmpty('percentage');
            
        $validator
            ->add('bill_amount', 'valid', ['rule' => 'numeric'])
          //  ->requirePresence('bill_amount', 'create')
            ->allowEmpty('bill_amount');
            
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
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
     //   $rules->add($rules->existsIn(['measurement_book_id'], 'MeasurementBooks'));
        return $rules;
    }
}
