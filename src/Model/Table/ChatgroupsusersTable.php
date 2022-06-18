<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chatgroupsusers Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Chatgroups
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Chatgroupsuser get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chatgroupsuser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chatgroupsuser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chatgroupsuser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatgroupsuser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chatgroupsuser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chatgroupsuser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chatgroupsuser findOrCreate($search, callable $callback = null, $options = [])
 */
class ChatgroupsusersTable extends Table
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

        $this->setTable('chatgroupsusers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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

       /*   $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
        ]); */
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
        //$rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
