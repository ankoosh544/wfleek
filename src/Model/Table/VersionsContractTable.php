<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VersionsContract Model
 *
 * @property \App\Model\Table\ProjectObjectsTable|\Cake\ORM\Association\BelongsTo $ProjectObjects
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\VersionsContract get($primaryKey, $options = [])
 * @method \App\Model\Entity\VersionsContract newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VersionsContract[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VersionsContract|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VersionsContract saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VersionsContract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VersionsContract[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VersionsContract findOrCreate($search, callable $callback = null, $options = [])
 */
class VersionsContractTable extends Table
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

        $this->setTable('versions_contract');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProjectObjects', [
            'foreignKey' => 'project_object_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id',
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('listof_members')
            ->maxLength('listof_members', 16777215)
            ->allowEmptyString('listof_members');

        $validator
            ->scalar('content')
            ->maxLength('content', 16777215)
            ->allowEmptyString('content');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->dateTime('acceptance_date')
            ->allowEmptyDateTime('acceptance_date', false);

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
       // $rules->add($rules->existsIn(['project_object_id'], 'ProjectObjects'));
        //$rules->add($rules->existsIn(['contract_id'], 'Contracts'));

        return $rules;
    }
}
