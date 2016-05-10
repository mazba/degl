<?php
namespace App\Model\Table;

use App\Model\Entity\Item;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 */
class ItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('items');
        $this->displayField('item_display_code');
        $this->primaryKey('id');
        $this->belongsTo('Chapters', [
            'foreignKey' => 'chapter_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SchemeAmounts', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('SchemeDetails', [
            'foreignKey' => 'item_id'
        ]);
        $this->hasMany('SchemeItemBreakups', [
            'foreignKey' => 'item_id'
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
            ->requirePresence('item_display_code', 'create')
            ->notEmpty('item_display_code');
            
        $validator
            ->add('main_code', 'valid', ['rule' => 'numeric'])
            ->requirePresence('main_code', 'create')
            ->notEmpty('main_code');
            
        $validator
            ->allowEmpty('description');
            
        $validator
            ->add('level', 'valid', ['rule' => 'numeric'])
            ->requirePresence('level', 'create')
            ->notEmpty('level');
            
        $validator
            ->requirePresence('unit', 'create')
            ->notEmpty('unit');
            
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
        $rules->add($rules->existsIn(['chapter_id'], 'Chapters'));
        return $rules;
    }
}
