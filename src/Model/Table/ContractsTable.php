<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contracts Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $ProjectObject
 * @property \App\Model\Table\ContractlinesTable|\Cake\ORM\Association\HasMany $Contractlines
 *
 * @method \App\Model\Entity\Contract get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contract newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Contract[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contract|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contract saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contract[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contract findOrCreate($search, callable $callback = null, $options = [])
 */
class ContractsTable extends Table
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

        $this->setTable('contracts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProjectObject', [
            'foreignKey' => 'project_object_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Contractlines', [
            'foreignKey' => 'contract_id'
        ]);
        $this->hasMany('Versions', [
            'className' => 'VersionsContract',
            'foreignKey' => 'contract_id'
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
            ->allowEmptyDateTime('acceptance_date');

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
       // $rules->add($rules->existsIn(['project_object_id'], 'ProjectObject'));

        return $rules;
    }
}
