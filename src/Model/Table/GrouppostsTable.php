<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groupposts Model
 *
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property |\Cake\ORM\Association\BelongsTo $User
 * @property \App\Model\Table\GrouppostfilesTable|\Cake\ORM\Association\HasMany $Grouppostfiles
 *
 * @method \App\Model\Entity\Grouppost get($primaryKey, $options = [])
 * @method \App\Model\Entity\Grouppost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Grouppost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Grouppost|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grouppost saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grouppost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Grouppost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Grouppost findOrCreate($search, callable $callback = null, $options = [])
 */
class GrouppostsTable extends Table
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

        $this->setTable('groupposts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
        ]);

        $this->belongsTo('Groupnotes', [
            'className' => 'Groupnotes',
            'foreignKey' => 'id',
            'bindingKey' => 'post_id'

        ]);
        $this->hasMany('Postlikes', [
            'className' => 'Postlikes',
            'foreignKey' => 'post_id',
            'bindingKey' => 'id'
        ]);


        $this->hasMany('Grouppostfiles', [
            'foreignKey' => 'grouppost_id'
        ]);
         $this->hasMany('Groupposttagmembers', [
            'className' => 'Groupposttagmembers',
            'foreignKey' => 'post_id',
            'bindingKey' => 'id'
        ]);


        $this->hasMany('Postcomments', [
            'className' => 'Postcomments',
            'foreignKey' => 'post_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Favoriteposts', [
            'foreignKey' => 'post_id',
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
            ->scalar('post_data')
            ->maxLength('post_data', 500)
            ->allowEmptyString('post_data');

        $validator
            ->boolean('isDeleted')
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
       // $rules->add($rules->existsIn(['group_id'], 'Groups'));
       // $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
