<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FileObject Model
 *
 * @method \App\Model\Entity\FileObject get($primaryKey, $options = [])
 * @method \App\Model\Entity\FileObject newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FileObject[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FileObject|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FileObject saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FileObject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FileObject[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FileObject findOrCreate($search, callable $callback = null, $options = [])
 */
class FileObjectTable extends Table
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

        $this->setTable('file_object');
        $this->setDisplayField('marker');
        $this->setPrimaryKey(['marker', 'cnt']);
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
            ->dateTime('marker')
            ->allowEmptyDateTime('marker', 'create');

        $validator
            ->allowEmptyString('cnt', 'create');

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->scalar('displayFileName')
            ->maxLength('displayFileName', 255)
            ->allowEmptyString('displayFileName');

        $validator
            ->scalar('originalFileName')
            ->maxLength('originalFileName', 255)
            ->allowEmptyString('originalFileName');

        $validator
            ->scalar('codeExt')
            ->maxLength('codeExt', 10)
            ->allowEmptyString('codeExt');

        $validator
            ->scalar('storeFileName')
            ->maxLength('storeFileName', 255)
            ->allowEmptyString('storeFileName');

        $validator
            ->scalar('storePath')
            ->maxLength('storePath', 255)
            ->allowEmptyString('storePath');

        $validator
            ->scalar('storeServerName')
            ->maxLength('storeServerName', 255)
            ->allowEmptyString('storeServerName');

        $validator
            ->scalar('storeServerIp')
            ->maxLength('storeServerIp', 45)
            ->allowEmptyString('storeServerIp');

        $validator
            ->integer('storeFileSize')
            ->allowEmptyString('storeFileSize');

        $validator
            ->dateTime('storeFileDateTime')
            ->allowEmptyDateTime('storeFileDateTime');

        $validator
            ->requirePresence('ownerId', 'create')
            ->allowEmptyString('ownerId', false);

        $validator
            ->scalar('checksumId')
            ->maxLength('checksumId', 10)
            ->allowEmptyString('checksumId');

        $validator
            ->scalar('checksumString')
            ->maxLength('checksumString', 255)
            ->allowEmptyString('checksumString');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
