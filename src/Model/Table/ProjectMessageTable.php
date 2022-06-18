<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectMessage Model
 *
 * @method \App\Model\Entity\ProjectMessage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectMessage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectMessage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMessage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectMessage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectMessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMessage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMessage findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectMessageTable extends Table
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

        $this->setTable('project_message');
        $this->setDisplayField('projectId');
        $this->setPrimaryKey(['projectId', 'senderId', 'createDate']);
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
            ->allowEmptyString('senderId', 'create');

        $validator
            ->dateTime('createDate')
            ->allowEmptyDateTime('createDate', 'create');

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->scalar('text')
            ->maxLength('text', 16777215)
            ->requirePresence('text', 'create')
            ->allowEmptyString('text', false);

        $validator
            ->scalar('langId')
            ->maxLength('langId', 2)
            ->requirePresence('langId', 'create')
            ->allowEmptyString('langId', false);

        $validator
            ->allowEmptyString('fatherProjectId');

        $validator
            ->allowEmptyString('fatherSenderId');

        $validator
            ->dateTime('fatherCreateDate')
            ->allowEmptyDateTime('fatherCreateDate');

        $validator
            ->integer('level')
            ->allowEmptyString('level');

        $validator
            ->allowEmptyString('referenceProjectId');

        $validator
            ->allowEmptyString('referenceSenderId');

        $validator
            ->dateTime('referenceCreateDate')
            ->allowEmptyDateTime('referenceCreateDate');

        return $validator;
    }
}
