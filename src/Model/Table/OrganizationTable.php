<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Organization Model
 *
 * @method \App\Model\Entity\Organization get($primaryKey, $options = [])
 * @method \App\Model\Entity\Organization newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Organization[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Organization|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Organization saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Organization patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Organization[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Organization findOrCreate($search, callable $callback = null, $options = [])
 */
class OrganizationTable extends Table
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

        $this->setTable('organization');
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
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', false);

        $validator
            ->requirePresence('anagId', 'create')
            ->allowEmptyString('anagId', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->boolean('isCompany')
            ->requirePresence('isCompany', 'create')
            ->allowEmptyString('isCompany', false);

        $validator
            ->boolean('isMiur')
            ->allowEmptyString('isMiur');

        $validator
            ->dateTime('createDate')
            ->allowEmptyDateTime('createDate');

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
            ->boolean('isBlocked')
            ->allowEmptyString('isBlocked');

        $validator
            ->dateTime('blockDate')
            ->allowEmptyDateTime('blockDate');

        $validator
            ->scalar('blockReason')
            ->maxLength('blockReason', 200)
            ->allowEmptyString('blockReason');

        $validator
            ->allowEmptyString('fatherId');

        $validator
            ->integer('level')
            ->allowEmptyString('level');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
