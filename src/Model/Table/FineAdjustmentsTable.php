<?php
namespace App\Model\Table;

use App\Model\Entity\FineAdjustment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FineAdjustments Model
 */
class FineAdjustmentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('fine_adjustments');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
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
            ->allowEmpty('economic_code');
            
        $validator
            ->add('adjusted_amount', 'valid', ['rule' => 'numeric'])
            ->requirePresence('adjusted_amount', 'create')
            ->notEmpty('adjusted_amount');
            
        $validator
            ->allowEmpty('reason');
            
        $validator
            ->add('created_dayte', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('created_dayte');
            
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
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
