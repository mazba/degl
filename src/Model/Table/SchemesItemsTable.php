<?php
namespace App\Model\Table;

use App\Model\Entity\SchemesItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SchemesItems Model
 */
class SchemesItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('schemes_items');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
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
            ->requirePresence('item_display_code', 'create')
            ->notEmpty('item_display_code');
            
        $validator
            ->allowEmpty('description');
            
        $validator
            ->requirePresence('unit', 'create')
            ->notEmpty('unit');
            
        $validator
            ->add('rate', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('rate');
            
        $validator
            ->add('quantity', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('quantity');
            
        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');
            
        $validator
            ->add('created_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_date', 'create')
            ->notEmpty('created_date');
            
        $validator
            ->add('updated_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('updated_by');
            
        $validator
            ->add('updated_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('updated_date');
            
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
