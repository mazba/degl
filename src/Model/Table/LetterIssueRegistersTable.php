<?php
namespace App\Model\Table;

use App\Model\Entity\LetterIssueRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LetterIssueRegisters Model
 */
class LetterIssueRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('letter_issue_registers');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('NothiRegisters', [
            'foreignKey' => 'nothi_register_id'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
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
            
//        $validator
//            ->requirePresence('sarok_no', 'create')
//            ->notEmpty('sarok_no');
            
        $validator
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');
            
//        $validator
//            ->add('sender_office', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('sender_office');
//
//        $validator
//            ->allowEmpty('sender_department');
//
//        $validator
//            ->allowEmpty('letter_type');
//
//        $validator
//            ->add('receiver_office', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('receiver_office');
            
        $validator
            ->allowEmpty('receiver_name');
            
        $validator
            ->allowEmpty('receiver_designation');
//
//        $validator
//            ->allowEmpty('receiver_phone');
//
//        $validator
//            ->allowEmpty('receiver_email');
//
//        $validator
//            ->allowEmpty('receiver_fax');
//
//        $validator
//            ->allowEmpty('receiver_address');
            
        $validator
            ->add('issue_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('issue_date');
            
        $validator
            ->requirePresence('letter_nature', 'create')
            ->notEmpty('letter_nature');
            
        $validator
            ->allowEmpty('remarks');
            
        $validator
            ->add('is_urgent', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_urgent');
            
        $validator
            ->add('is_answer_required', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_answer_required');
            
        $validator
            ->add('answer_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('answer_date');
            
        $validator
            ->add('is_guard_file', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_guard_file');
            
        $validator
            ->add('parent_letter', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('parent_letter');
            
        $validator
            ->add('is_hardcopy_attached', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_hardcopy_attached');
            
        $validator
            ->add('number_of_pages', 'valid', ['rule' => 'numeric'])
            ->requirePresence('number_of_pages', 'create')
            ->notEmpty('number_of_pages');
            
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
        $rules->add($rules->existsIn(['nothi_register_id'], 'NothiRegisters'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
