<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projecttasks Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Projects
 * @property |\Cake\ORM\Association\BelongsToMany $Taskgroups
 *
 * @method \App\Model\Entity\Projecttask get($primaryKey, $options = [])
 * @method \App\Model\Entity\Projecttask newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Projecttask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Projecttask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Projecttask saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Projecttask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Projecttask[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Projecttask findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjecttasksTable extends Table
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

        $this->setTable('projecttasks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Statusupdatedby', [
            'className' => 'User',
            'foreignKey' => 'status_updatedby',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Createduser', [
            'className' => 'User',
            'foreignKey' => 'creatorId',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('Projectobject', [
            'className' => 'ProjectObject',
            'foreignKey' => 'project_id'
        ]);
        $this->belongsToMany('Taskgroups', [
            'foreignKey' => 'projecttask_id',
            'targetForeignKey' => 'taskgroup_id',
            'joinTable' => 'taskgroups_projecttasks'
        ]);

        $this->hasMany('Taskgroupsprojecttasks', [
            'className' => 'TaskgroupsProjecttasks',
            'foreignKey' => 'projecttask_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('EpictasksProjecttasks', [
            'className' => 'EpictasksProjecttasks',
            'foreignKey' => 'epictask_id',
            'bindingKey' => 'id'

        ]);

         $this->hasMany('Subtasks', [
            'className' => 'EpictasksProjecttasks',
            'foreignKey' => 'projecttask_id',
            'bindingKey' => 'id'

        ]);
        $this->hasMany('TaskComments',[
            'className' => 'Comments',
            'foreignKey' => 'taskId',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Taskusers',[
            'className' => 'Taskusers',
            'foreignKey' => 'taskId',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Followers',[
            'className' => 'Followers',
            'foreignKey' => 'task_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Taskfiles',[
            'className' => 'Taskfiles',
            'foreignKey' => 'tid',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Tasktickets',[
            'className' => 'Projecttasks',
            'foreignkey' => 'referred_taskId',
            'bindingKey' => 'id'

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
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->decimal('tax_percentage')
            ->allowEmptyString('tax_percentage');

        $validator
            ->scalar('status')
            ->maxLength('status', 1)
            ->allowEmptyString('status', false);

        $validator
            ->scalar('type')
            ->maxLength('type', 2)
            ->allowEmptyString('type', false);

        $validator
            ->boolean('isApproved')
            ->allowEmptyString('isApproved', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        $validator
            ->dateTime('expiration_date')
            ->allowEmptyDateTime('expiration_date', false);

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

        return $rules;
    }
}
