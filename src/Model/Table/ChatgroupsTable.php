<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chatgroups Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Chatgroups
 *
 * @method \App\Model\Entity\Chatgroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chatgroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chatgroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chatgroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatgroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatgroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chatgroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chatgroup findOrCreate($search, callable $callback = null, $options = [])
 */
class ChatgroupsTable extends Table
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

        $this->setTable('chatgroups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Groupchatfiles', [
            'className' => 'Groupchatfiles',
            'foreignKey' => 'group_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Chatgroupsusers', [
            'className' => 'Chatgroupsusers',
            'foreignKey' => 'group_id',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('Chatgroups', [
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->allowEmptyString('name');

        $validator
            ->requirePresence('creator', 'create')
            ->allowEmptyString('creator', false);

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
        //$rules->add($rules->existsIn(['group_id'], 'Chatgroups'));

        return $rules;
    }
}
