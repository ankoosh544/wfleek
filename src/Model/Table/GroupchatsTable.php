<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groupchats Model
 *
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\Groupchat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Groupchat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Groupchat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Groupchat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupchat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupchat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Groupchat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Groupchat findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupchatsTable extends Table
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

        $this->setTable('groupchats');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Groupchatfiles', [
            'className' => 'Groupchatfiles',
            'foreignKey' => 'groupchat_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Replies', [
            'className' => 'Groupchats',
            'foreignKey' => 'parentgroupchat_id',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('Chatgroups', [
            'className' => 'Chatgroups',
            'foreignKey' => 'group_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'className' => 'User',
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
            ->scalar('content')
            ->maxLength('content', 250)
            ->allowEmptyString('content');

        $validator
            ->dateTime('creation_date')
            ->requirePresence('creation_date', 'create')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->dateTime('last_update')
            ->requirePresence('last_update', 'create')
            ->allowEmptyDateTime('last_update', false);

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
       // $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }
}
