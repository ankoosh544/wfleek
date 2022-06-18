<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Onsiteemployees Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property |\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Onsiteemployee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Onsiteemployee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Onsiteemployee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Onsiteemployee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Onsiteemployee saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Onsiteemployee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Onsiteemployee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Onsiteemployee findOrCreate($search, callable $callback = null, $options = [])
 */
class OnsiteemployeesTable extends Table
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

        $this->setTable('onsiteemployees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Worklocations', [
            'className' => 'Worklocations',
            'foreignKey' => 'work_location_Id',
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
            ->requirePresence('projectId', 'create')
            ->allowEmptyString('projectId', false);

        $validator
            ->requirePresence('work_location_Id', 'create')
            ->allowEmptyString('work_location_Id', false);

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

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
      //  $rules->add($rules->existsIn(['client_id'], 'Clients'));
       // $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
