<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employeesdailyworkflow Model
 *
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Employeesdailyworkflow get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employeesdailyworkflow findOrCreate($search, callable $callback = null, $options = [])
 */
class EmployeesdailyworkflowTable extends Table
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

        $this->setTable('employeesdailyworkflow');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
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
            ->scalar('status')
            ->maxLength('status', 150)
            ->allowEmptyString('status');

        $validator
            ->dateTime('fromdate')
            ->allowEmptyDateTime('fromdate');

        $validator
            ->dateTime('todate')
            ->allowEmptyDateTime('todate');

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
        $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
