<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ECourse Model
 *
 * @method \App\Model\Entity\ECourse get($primaryKey, $options = [])
 * @method \App\Model\Entity\ECourse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ECourse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ECourse|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ECourse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ECourse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ECourse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ECourse findOrCreate($search, callable $callback = null, $options = [])
 */
class ECourseTable extends Table
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

        $this->setTable('e_course');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
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
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->scalar('title')
            ->maxLength('title', 70)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        $validator
            ->scalar('subtitle')
            ->maxLength('subtitle', 250)
            ->allowEmptyString('subtitle');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('languageCode')
            ->maxLength('languageCode', 2)
            ->requirePresence('languageCode', 'create')
            ->allowEmptyString('languageCode', false);

        $validator
            ->requirePresence('ownerId', 'create')
            ->allowEmptyString('ownerId', false);

        $validator
            ->allowEmptyString('organizationId');

        $validator
            ->boolean('isFree')
            ->allowEmptyString('isFree');

        $validator
            ->boolean('isRestrictedAccess')
            ->allowEmptyString('isRestrictedAccess');

        $validator
            ->boolean('isInternal')
            ->allowEmptyString('isInternal');

        $validator
            ->scalar('status')
            ->maxLength('status', 3)
            ->allowEmptyString('status');

        $validator
            ->boolean('isApprovalRequired')
            ->allowEmptyString('isApprovalRequired');

        $validator
            ->dateTime('createDate')
            ->allowEmptyDateTime('createDate');

        $validator
            ->requirePresence('creatorId', 'create')
            ->allowEmptyString('creatorId', false);

        $validator
            ->dateTime('lastUpdate')
            ->allowEmptyDateTime('lastUpdate');

        $validator
            ->allowEmptyString('matterId');

        $validator
            ->allowEmptyString('eCategoryId');

        $validator
            ->scalar('password')
            ->maxLength('password', 245)
            ->allowEmptyString('password');

        $validator
            ->date('startDate')
            ->allowEmptyDate('startDate');

        $validator
            ->date('endDate')
            ->allowEmptyDate('endDate');

        $validator
            ->date('endSubscriptionDate')
            ->allowEmptyDate('endSubscriptionDate');

        $validator
            ->boolean('isObsolete')
            ->allowEmptyString('isObsolete');

        $validator
            ->boolean('isVisible')
            ->allowEmptyString('isVisible');

        $validator
            ->boolean('isOffLine')
            ->allowEmptyString('isOffLine');

        $validator
            ->scalar('bibliography')
            ->maxLength('bibliography', 16777215)
            ->allowEmptyString('bibliography');

        $validator
            ->allowEmptyString('xUBInt1');

        $validator
            ->allowEmptyString('xUBint2');

        $validator
            ->integer('xInt')
            ->allowEmptyString('xInt');

        $validator
            ->boolean('isXCond1')
            ->allowEmptyString('isXCond1');

        $validator
            ->boolean('isXCond2')
            ->allowEmptyString('isXCond2');

        $validator
            ->scalar('xChar1')
            ->maxLength('xChar1', 1)
            ->allowEmptyString('xChar1');

        $validator
            ->scalar('xString1')
            ->maxLength('xString1', 45)
            ->allowEmptyString('xString1');

        $validator
            ->scalar('xString2')
            ->maxLength('xString2', 45)
            ->allowEmptyString('xString2');

        $validator
            ->scalar('xString3')
            ->maxLength('xString3', 45)
            ->allowEmptyString('xString3');

        return $validator;
    }
}
