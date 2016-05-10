<?php
namespace App\Model\Table;

use App\Model\Entity\MessageRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MessageRegisters Model
 */
class MessageRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('message_registers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
        ]);

        $this->hasMany('Recipients', [
            'foreignKey' => 'message_register_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'sender_id'
        ]);

        $this->belongsTo('ReceiveFileRegisters', [
            'foreignKey' => 'resource_id'
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
            ->allowEmpty('sender_name');
            
        $validator
            ->allowEmpty('sender_designation');
            
        $validator
            ->allowEmpty('subject');
            
        $validator
            ->allowEmpty('work_description');
            
        $validator
            ->allowEmpty('msg_type');
            
        $validator
            ->allowEmpty('message_text');
            
        $validator
            ->allowEmpty('msg_flow_control');
            
        $validator
            ->allowEmpty('msg_direction');
            
        $validator
            ->add('is_out_side', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('is_out_side');
            
        $validator
            ->add('urgent_type', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('urgent_type');
            
        $validator
            ->add('is_attached', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('is_attached');
            
        $validator
            ->add('created_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_date', 'create')
            ->notEmpty('created_date');

        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');
            
        $validator
            ->add('is_read', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('is_read');

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

        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
