<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Taskusers Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Taskuser get($primaryKey, $options = [])
 * @method \App\Model\Entity\Taskuser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Taskuser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Taskuser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Taskuser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Taskuser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Taskuser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Taskuser findOrCreate($search, callable $callback = null, $options = [])
 */
class TaskusersTable extends Table
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

        $this->setTable('taskusers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'assignee_id',
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
            ->requirePresence('taskId', 'create')
            ->allowEmptyString('taskId', false);

        $validator
            ->dateTime('assigned_date')
            ->allowEmptyDateTime('assigned_date', false);

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
        $rules->add($rules->existsIn(['assignee_id'], 'User'));

        return $rules;
    }
}
