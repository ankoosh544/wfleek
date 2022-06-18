<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectMessageAttachment Model
 *
 * @method \App\Model\Entity\ProjectMessageAttachment get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectMessageAttachment findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectMessageAttachmentTable extends Table
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

        $this->setTable('project_message_attachment');
        $this->setDisplayField('projectId');
        $this->setPrimaryKey(['projectId', 'senderId', 'createDate', 'fileMarker', 'fileCnt']);
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
            ->dateTime('fileMarker')
            ->allowEmptyDateTime('fileMarker', 'create');

        $validator
            ->allowEmptyFile('fileCnt', 'create');

        $validator
            ->integer('iconId')
            ->requirePresence('iconId', 'create')
            ->allowEmptyString('iconId', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 70)
            ->allowEmptyString('description');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
