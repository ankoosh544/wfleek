<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chatfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $User
 * @property |\Cake\ORM\Association\BelongsTo $User
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\Chatfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chatfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chatfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chatfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chatfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chatfile findOrCreate($search, callable $callback = null, $options = [])
 */
class ChatfilesTable extends Table
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

        $this->setTable('chatfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Touser', [
            'className' => 'User',
            'foreignKey' => 'touser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
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
            ->scalar('filename')
            ->maxLength('filename', 250)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 250)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('type')
            ->maxLength('type', 250)
            ->allowEmptyString('type');

        $validator
            ->integer('size')
            ->allowEmptyString('size');

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
       // $rules->add($rules->existsIn(['user_id'], 'User'));
       // $rules->add($rules->existsIn(['touser_id'], 'User'));
       // $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }
}
