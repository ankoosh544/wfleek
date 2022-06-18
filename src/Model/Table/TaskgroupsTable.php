<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Taskgroups Model
 *
 * @property \App\Model\Table\ProjecttasksTable|\Cake\ORM\Association\BelongsToMany $Projecttasks
 *
 * @method \App\Model\Entity\Taskgroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Taskgroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Taskgroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Taskgroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Taskgroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Taskgroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Taskgroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Taskgroup findOrCreate($search, callable $callback = null, $options = [])
 */
class TaskgroupsTable extends Table
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

        $this->setTable('taskgroups');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Projecttasks', [
            'foreignKey' => 'taskgroup_id',
            'targetForeignKey' => 'projecttask_id',
            'joinTable' => 'taskgroups_projecttasks'
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
            ->allowEmptyString('description');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->decimal('tax_percentage')
            ->allowEmptyString('tax_percentage');

        $validator
            ->dateTime('last_update')
            ->allowEmptyDateTime('last_update');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date');

        return $validator;
    }
}
