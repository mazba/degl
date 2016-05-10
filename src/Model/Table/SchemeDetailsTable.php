<?php
namespace App\Model\Table;

use App\Model\Entity\SchemeDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SchemeDetails Model
 */
class SchemeDetailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('scheme_details');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
            ->requirePresence('scheme_status', 'create')
            ->notEmpty('scheme_status');
            
        $validator
            ->add('comp_serial_no', 'valid', ['rule' => 'numeric'])
            ->requirePresence('comp_serial_no', 'create')
            ->notEmpty('comp_serial_no');
            
        $validator
            ->add('deducation', 'valid', ['rule' => 'numeric'])
            ->requirePresence('deducation', 'create')
            ->notEmpty('deducation');

        $validator
            ->allowEmpty('component_location');
            
        $validator
            ->add('cl_length', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cl_length');
            
        $validator
            ->add('cl_width', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cl_width');
            
        $validator
            ->add('cl_height_depth', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cl_height_depth');
            
        $validator
            ->add('cl_area_volume', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cl_area_volume');
            
        $validator
            ->add('item_quantity', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('item_quantity');
            
        $validator
            ->add('has_breakup', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('has_breakup');
            
        $validator
            ->allowEmpty('remarks');
            
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
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        return $rules;
    }
}
