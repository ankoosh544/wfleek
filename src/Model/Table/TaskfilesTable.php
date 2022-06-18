<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Taskfiles Model
 *
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\BelongsTo $Comments
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Taskfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Taskfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Taskfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Taskfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Taskfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Taskfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Taskfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Taskfile findOrCreate($search, callable $callback = null, $options = [])
 */
class TaskfilesTable extends Table
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

        $this->setTable('taskfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Comments', [
            'foreignKey' => 'comment_id'
        ]);
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
            ->requirePresence('pid', 'create')
            ->allowEmptyString('pid', false);

        $validator
            ->requirePresence('tid', 'create')
            ->allowEmptyString('tid', false);

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 255)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->integer('size')
            ->requirePresence('size', 'create')
            ->allowEmptyString('size', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

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
        $rules->add($rules->existsIn(['comment_id'], 'Comments'));
        $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
