<?php
namespace App\Model\Table;

use App\Model\Entity\VehiclesStatus;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VehiclesStatus Model
 */
class VehiclesStatusTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('vehicles_status');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
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
            ->allowEmpty('vehicle_location');
            
        $validator
            ->allowEmpty('remark');
            
        $validator
            ->add('assign_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('assign_date', 'create')
            ->notEmpty('assign_date');
            
        $validator
            ->add('end_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('end_date');
            
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
        $rules->add($rules->existsIn(['vehicle_id'], 'Vehicles'));
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
