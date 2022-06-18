<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groupposttagmembers Model
 *
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property |\Cake\ORM\Association\BelongsTo $Groupposts
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Comments
 * @property |\Cake\ORM\Association\BelongsTo $Replies
 *
 * @method \App\Model\Entity\Groupposttagmember get($primaryKey, $options = [])
 * @method \App\Model\Entity\Groupposttagmember newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Groupposttagmember[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Groupposttagmember|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupposttagmember saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupposttagmember patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Groupposttagmember[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Groupposttagmember findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupposttagmembersTable extends Table
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

        $this->setTable('groupposttagmembers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Groupposts', [
            'foreignKey' => 'post_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Comments', [
            'foreignKey' => 'comment_id'
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
            ->boolean('isPost')
            ->allowEmptyString('isPost', false);

        $validator
            ->boolean('isComment')
            ->allowEmptyString('isComment', false);

        $validator
            ->boolean('isReply')
            ->allowEmptyString('isReply', false);

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
      //  $rules->add($rules->existsIn(['group_id'], 'Groups'));
      //  $rules->add($rules->existsIn(['post_id'], 'Groupposts'));
      //  $rules->add($rules->existsIn(['user_id'], 'Users'));
      //  $rules->add($rules->existsIn(['comment_id'], 'Comments'));
      //  $rules->add($rules->existsIn(['reply_id'], 'Replies'));

        return $rules;
    }
}
