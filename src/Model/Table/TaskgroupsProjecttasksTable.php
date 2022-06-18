<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


/**
 * TaskgroupsProjecttasks Model
 *
 * @property \App\Model\Table\TaskgroupsTable|\Cake\ORM\Association\BelongsTo $Taskgroups
 * @property \App\Model\Table\ProjecttasksTable|\Cake\ORM\Association\BelongsTo $Projecttasks
 *
 * @method \App\Model\Entity\TaskgroupsProjecttask get($primaryKey, $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TaskgroupsProjecttask findOrCreate($search, callable $callback = null, $options = [])
 */
class TaskgroupsProjecttasksTable extends Table
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

        $this->setTable('taskgroups_projecttasks');

         $this->belongsTo('Taskgroups', [
            'foreignKey' => 'taskgroup_id'
        ]);
       $this->belongsTo('Projecttasks', [
            'foreignKey' => 'projecttask_id'
        ]);

      /*   $this->hasMany('Taskgroups', [
            'className' => 'Taskgroups',
            'foreignKey' => 'taskgroup_id',
            'bindingKey' => 'id'
        ]); */
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
       // $rules->add($rules->existsIn(['taskgroup_id'], 'Taskgroups'));
      //  $rules->add($rules->existsIn(['projecttask_id'], 'Projecttasks'));

        return $rules;
    }
}
