<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectMember Model
 *
 * @method \App\Model\Entity\ProjectMember get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectMember newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectMember[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMember|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectMember saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectMember patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMember[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMember findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectMemberTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);


       // $this->belongsTo('User');
    //    $this->belongsTo('User')
    //    ->setForeignKey('user_id');

        $this->setTable('project_member');
        $this->setDisplayField('projectId');
        $this->setPrimaryKey('id');


      /*   $this->belongsTo('ProjectObject', [
            'foreignKey' => 'projectId',
            'bindingKey' => 'id'
        ]); */
        $this->hasOne('Projectobject', [
            'foreignKey' => 'id',
            'bindingKey' => 'projectId'
        ]);

        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'memberId',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Designations',[
            'foreignKey' => 'designation_id',
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
            ->allowEmptyString('projectId', 'create');

        $validator
            ->scalar('memberType')
            ->maxLength('memberType', 1)
            ->allowEmptyString('memberType', 'create');

        $validator
            ->allowEmptyString('memberId', 'create');

        $validator
            ->integer('accessLevel')
            ->allowEmptyString('accessLevel');

        $validator
            ->dateTime('joinDate')
            ->allowEmptyDateTime('joinDate');

        $validator
            ->allowEmptyString('sponsorId');

        $validator
            ->boolean('isInvitation')
            ->allowEmptyString('isInvitation');

        $validator
            ->dateTime('invitationDate')
            ->allowEmptyDateTime('invitationDate');

        $validator
            ->boolean('isMembershipRequest')
            ->allowEmptyString('isMembershipRequest');

        $validator
            ->dateTime('membershipRequestDate')
            ->allowEmptyDateTime('membershipRequestDate');

        $validator
            ->boolean('isBanned')
            ->allowEmptyString('isBanned');

        $validator
            ->dateTime('banDate')
            ->allowEmptyDateTime('banDate');

        $validator
            ->allowEmptyString('bannerId');

        $validator
            ->scalar('banReason')
            ->maxLength('banReason', 250)
            ->allowEmptyString('banReason');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
