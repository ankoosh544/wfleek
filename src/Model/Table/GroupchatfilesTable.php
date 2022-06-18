<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groupchatfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Groupchats
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Groupchatfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Groupchatfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Groupchatfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Groupchatfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupchatfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupchatfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Groupchatfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Groupchatfile findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupchatfilesTable extends Table
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

        $this->setTable('groupchatfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groupchats', [
            'className' => 'Groupchats',
            'foreignKey' => 'groupchat_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Chatgroups', [
            'className' => 'Chatgroups',
            'foreignKey' => 'group_id',
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
       // $rules->add($rules->existsIn(['groupchat_id'], 'Groupchats'));
        //$rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
