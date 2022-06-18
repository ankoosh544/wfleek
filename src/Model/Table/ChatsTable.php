<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chats Model
 *
 * @property \App\Model\Table\ChatgroupsTable|\Cake\ORM\Association\BelongsTo $Chatgroups
 * @property |\Cake\ORM\Association\BelongsTo $User
 * @property |\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Chat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chat findOrCreate($search, callable $callback = null, $options = [])
 */
class ChatsTable extends Table
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

        $this->setTable('chats');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Chatfiles', [
            'foreignKey' => 'chat_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Replies', [
            'className' => 'Chats',
            'foreignKey' => 'parentchat_id',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('Chatgroups', [
            'foreignKey' => 'chatgroup_id'
        ]);
        $this->belongsTo('FromUser', [
            'className' =>'User',
            'foreignKey' => 'fromuser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ToUser', [
            'className' => 'User',
            'foreignKey' => 'touser_id',
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
            ->scalar('content')
            ->maxLength('content', 250)
            ->allowEmptyString('content');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->dateTime('last_update')
            ->requirePresence('last_update', 'create')
            ->allowEmptyDateTime('last_update', false);

        $validator
            ->boolean('isSeen')
            ->allowEmptyString('isSeen', false);

        $validator
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
       // $rules->add($rules->existsIn(['chatgroup_id'], 'Chatgroups'));
       // $rules->add($rules->existsIn(['fromuser_id'], 'User'));
        //$rules->add($rules->existsIn(['touser_id'], 'User'));

        return $rules;
    }
}
