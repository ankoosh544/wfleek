<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ChatgroupsTable|\Cake\ORM\Association\HasMany $Chatgroups
 * @property \App\Model\Table\ChatgroupsusersTable|\Cake\ORM\Association\HasMany $Chatgroupsusers
 * @property \App\Model\Table\GroupchatfilesTable|\Cake\ORM\Association\HasMany $Groupchatfiles
 * @property \App\Model\Table\GroupchatsTable|\Cake\ORM\Association\HasMany $Groupchats
 * @property |\Cake\ORM\Association\HasMany $Groupmembers
 *
 * @method \App\Model\Entity\Group get($primaryKey, $options = [])
 * @method \App\Model\Entity\Group newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Group[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Group|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Group[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Group findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupsTable extends Table
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

        $this->setTable('groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id'
        ]);
        $this->hasMany('Chatgroups', [
            'foreignKey' => 'group_id'
        ]);
        $this->hasMany('Chatgroupsusers', [
            'foreignKey' => 'group_id'
        ]);
        $this->hasMany('Groupchatfiles', [
            'foreignKey' => 'group_id'
        ]);
        $this->hasMany('Groupchats', [
            'foreignKey' => 'group_id'
        ]);
        $this->hasMany('Groupmembers', [
            'className' => 'Groupmembers',
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'creatorId'
        ]);
        $this->hasMany('Groupposts', [
            'className' => 'Groupposts',
            'foreignKey' => 'group_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Grouppostfiles', [
            'className' => 'Grouppostfiles',
            'foreignKey' => 'group_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Groupnotes', [
            'className' => 'Groupnotes',
            'foreignKey' => 'group_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date');

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
       // $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
