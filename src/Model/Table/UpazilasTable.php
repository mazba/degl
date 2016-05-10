<?php
namespace App\Model\Table;

use App\Model\Entity\Upazila;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Upazilas Model
 */
class UpazilasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('upazilas');
        $this->displayField('name_en');
        $this->primaryKey('id');
        $this->belongsTo('Divisions', [
            'foreignKey' => 'division_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id',
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
            ->add('lged_syscode', 'valid', ['rule' => 'numeric'])
            ->requirePresence('lged_syscode', 'create')
            ->notEmpty('lged_syscode');
            
        $validator
            ->add('lged_code', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lged_code');
            
        $validator
            ->allowEmpty('upazila_geocode');
            
        $validator
            ->allowEmpty('district_name_en');
            
        $validator
            ->requirePresence('name_bn', 'create')
            ->notEmpty('name_bn');
            
        $validator
            ->allowEmpty('name_en');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['division_id'], 'Divisions'));
        $rules->add($rules->existsIn(['district_id'], 'Districts'));
        return $rules;
    }
}
