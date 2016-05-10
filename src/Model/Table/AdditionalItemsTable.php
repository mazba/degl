<?php
namespace App\Model\Table;

use App\Model\Entity\AdditionalItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdditionalItems Model
 */
class AdditionalItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('additional_items');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('item_display_code', 'create')
            ->notEmpty('item_display_code');
            
        $validator
            ->allowEmpty('description');
            
        $validator
            ->requirePresence('unit', 'create')
            ->notEmpty('unit');
            
        $validator
            ->add('rate', 'valid', ['rule' => 'numeric'])
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');

        return $validator;
    }
}
