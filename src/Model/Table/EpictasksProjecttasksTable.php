<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EpictasksProjecttasks Model
 *
 * @property \App\Model\Table\EpictasksTable|\Cake\ORM\Association\BelongsTo $Epictasks
 * @property \App\Model\Table\ProjecttasksTable|\Cake\ORM\Association\BelongsTo $Projecttasks
 *
 * @method \App\Model\Entity\EpictasksProjecttask get($primaryKey, $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EpictasksProjecttask findOrCreate($search, callable $callback = null, $options = [])
 */
class EpictasksProjecttasksTable extends Table
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

        $this->setTable('epictasks_projecttasks');
        $this->setDisplayField('epictask_id');
        $this->setPrimaryKey(['epictask_id', 'projecttask_id']);

        $this->belongsTo('Epictasks', [
            'className' => 'Projecttasks',
            'foreignKey' => 'epictask_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Projecttask', [
            'className' => 'Projecttasks',
            'foreignKey' => 'projecttask_id',
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
            ->requirePresence('projectId', 'create')
            ->allowEmptyString('projectId', false);

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
     //   $rules->add($rules->existsIn(['epictask_id'], 'Epictasks'));
      //  $rules->add($rules->existsIn(['projecttask_id'], 'Projecttasks'));

        return $rules;
    }
}
