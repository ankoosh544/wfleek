<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chatcontacts Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Tousers
 * @property |\Cake\ORM\Association\BelongsTo $Fromusers
 *
 * @method \App\Model\Entity\Chatcontact get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chatcontact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chatcontact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chatcontact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatcontact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatcontact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chatcontact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chatcontact findOrCreate($search, callable $callback = null, $options = [])
 */
class ChatcontactsTable extends Table
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

        $this->setTable('chatcontacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Chatfiles', [
            'foreignKey' => 'chat_id',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('ToUser', [
            'className' => 'User',
            'foreignKey' => 'touser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FromUser', [
            'className' => 'User',
            'foreignKey' => 'fromuser_id',
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
        //$rules->add($rules->existsIn(['touser_id'], 'Tousers'));
        //$rules->add($rules->existsIn(['fromuser_id'], 'Fromusers'));

        return $rules;
    }
}
