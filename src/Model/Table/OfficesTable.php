<?php
namespace App\Model\Table;

use App\Model\Entity\Office;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Offices Model
 */
class OfficesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('offices');
        $this->displayField('name_en');
        $this->primaryKey('id');
        $this->belongsTo('Divisions', [
            'foreignKey' => 'division_id'
        ]);
        $this->belongsTo('Zones', [
            'foreignKey' => 'zone_id'
        ]);
        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id'
        ]);
        $this->belongsTo('Upazilas', [
            'foreignKey' => 'upazila_id'
        ]);
        $this->hasMany('Designations', [
            'foreignKey' => 'office_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'office_id'
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
            ->requirePresence('office_code', 'create')
            ->notEmpty('office_code');
            
        $validator
            ->allowEmpty('office_short_title');
            
        $validator
            ->allowEmpty('office_level');
            
        $validator
            ->requirePresence('name_en', 'create')
            ->notEmpty('name_en');
            
        $validator
            ->requirePresence('name_bn', 'create')
            ->notEmpty('name_bn');
            
        $validator
            ->allowEmpty('office_contact_no');
        $validator
            ->allowEmpty('division_id');
        $validator
            ->allowEmpty('zone_id');
        $validator
            ->allowEmpty('district_id');
        $validator
            ->allowEmpty('upazila_id');
        $validator
            ->allowEmpty('address');
            
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
        //$rules->add($rules->existsIn(['division_id'], 'Divisions'));
        //$rules->add($rules->existsIn(['zone_id'], 'Zones'));
        //$rules->add($rules->existsIn(['district_id'], 'Districts'));
        //$rules->add($rules->existsIn(['upazila_id'], 'Upazilas'));
        return $rules;
    }
}
