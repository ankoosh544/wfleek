<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employeerequests Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Employeerequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employeerequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employeerequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employeerequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employeerequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employeerequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employeerequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employeerequest findOrCreate($search, callable $callback = null, $options = [])
 */
class EmployeerequestsTable extends Table
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

        $this->setTable('employeerequests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
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
            ->scalar('title')
            ->maxLength('title', 250)
            ->allowEmptyString('title');

        $validator
            ->scalar('request_type')
            ->maxLength('request_type', 150)
            ->allowEmptyString('request_type');

        $validator
            ->scalar('worktype')
            ->maxLength('worktype', 250)
            ->allowEmptyString('worktype');

        $validator
            ->scalar('status')
            ->maxLength('status', 1)
            ->allowEmptyString('status', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->dateTime('fromdate')
            ->requirePresence('fromdate', 'create')
            ->allowEmptyDateTime('fromdate', false);

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
       // $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
