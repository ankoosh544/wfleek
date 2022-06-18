<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectObject Model
 *
 * @method \App\Model\Entity\ProjectObject get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectObject newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectObject[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectObject|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectObject saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectObject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectObject[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectObject findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectObjectTable extends Table
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

        $this->setTable('project_object');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'creatorId',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Projectfiles', [
            'className' => 'Projectfiles',
            'foreignKey' => 'project_id',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('Projecttypes', [
            'foreignKey' => 'type',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Projectmembers', [
            'className' => 'ProjectMember',
            'foreignKey' => 'projectId',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Projecttasks', [
            'className' => 'Projecttasks',
            'foreignKey' => 'project_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Projecttaskgroups', [
            'className' => 'Taskgroups',
            'foreignKey' => 'projectId',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Taskgroups', [
            'className' => 'Taskgroups',
            'foreignKey' => 'projectId',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Contracts', [
            'className' => 'Contracts',
            'foreignKey' => 'project_object_id',
            'bindingKey' => 'id'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('superCode')
            ->maxLength('superCode', 252)
            ->allowEmptyString('superCode');

        $validator
            ->scalar('name')
            ->maxLength('name', 120)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 245)
            ->allowEmptyString('description');

        $validator
            ->scalar('description2')
            ->maxLength('description2', 245)
            ->allowEmptyString('description2');

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        $validator
            ->allowEmptyString('creatorId');

        $validator
            ->dateTime('createDate')
            ->allowEmptyDateTime('createDate');

        $validator
            ->scalar('visibility')
            ->maxLength('visibility', 1)
            ->allowEmptyString('visibility');

        $validator
            ->boolean('isSchool')
            ->allowEmptyString('isSchool', false);

        $validator
            ->boolean('isRestricted')
            ->allowEmptyString('isRestricted', false);

        $validator
            ->allowEmptyString('fatherId');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->allowEmptyString('level', false);

        $validator
            ->boolean('isMembershipRequestAllowed')
            ->allowEmptyString('isMembershipRequestAllowed', false);

        $validator
            ->boolean('isInvitationAllowed')
            ->allowEmptyString('isInvitationAllowed', false);

        $validator
            ->boolean('isBanAllowed')
            ->allowEmptyString('isBanAllowed', false);

        $validator
            ->scalar('imageFileName')
            ->maxLength('imageFileName', 255)
            ->allowEmptyFile('imageFileName');

        $validator
            ->scalar('imageFilePath')
            ->maxLength('imageFilePath', 255)
            ->allowEmptyFile('imageFilePath');

        $validator
            ->scalar('imageFileServer')
            ->maxLength('imageFileServer', 255)
            ->allowEmptyFile('imageFileServer');

        $validator
            ->allowEmptyFile('image');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

        $validator
            ->scalar('type')
            ->maxLength('type', 1)
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', false);

        $validator
            ->scalar('summary_title')
            ->maxLength('summary_title', 255)
            ->requirePresence('summary_title', 'create')
            ->allowEmptyString('summary_title', false);

        $validator
            ->scalar('summary_description')
            ->requirePresence('summary_description', 'create')
            ->allowEmptyString('summary_description', false);

        $validator
            ->scalar('member_names')
            ->maxLength('member_names', 20)
            ->requirePresence('member_names', 'create')
            ->allowEmptyString('member_names', false);

        return $validator;
    }
}
