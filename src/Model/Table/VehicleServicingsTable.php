<?php
namespace App\Model\Table;

use App\Model\Entity\VehicleServicing;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VehicleServicings Model
 */
class VehicleServicingsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('vehicle_servicings');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('VehicleServicingDetails', [
            'className' => 'VehicleServicingDetails',
            'foreignKey' => 'vehicle_servicing_id',
            'joinType' => 'INNER'
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
            ->add('breakdown_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('breakdown_date');
            
        $validator
            ->add('km_hr', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('km_hr');
            
        $validator
            ->add('is_periodic_maintenance', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_periodic_maintenance');
            
        $validator
            ->allowEmpty('defects');
            
        $validator
            ->add('servicing_start_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('servicing_start_date');
            
        $validator
            ->add('servicing_end_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('servicing_end_date');
            
        $validator
            ->allowEmpty('job_card');
            
        $validator
            ->add('service_charge', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('service_charge');
            
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
        $rules->add($rules->existsIn(['vehicle_id'], 'Vehicles'));
        return $rules;
    }
}
