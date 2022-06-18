<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Postcomments Model
 *
 * @property \App\Model\Table\PostcommentsTable|\Cake\ORM\Association\BelongsTo $ParentPostcomments
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PostcommentsTable|\Cake\ORM\Association\HasMany $ChildPostcomments
 *
 * @method \App\Model\Entity\Postcomment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Postcomment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Postcomment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Postcomment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postcomment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postcomment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Postcomment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Postcomment findOrCreate($search, callable $callback = null, $options = [])
 */
class PostcommentsTable extends Table
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

        $this->setTable('postcomments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');


        $this->belongsTo('Groups', [
            'className' => 'Groups',
            'foreignKey' => 'group_id'
        ]);


        $this->belongsTo('Posts', [
            'className' => 'Groupposts',
            'foreignKey' => 'post_id'
        ]);
        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Replies', [
            'className' => 'Postcomments',
            'foreignKey' => 'parent_id',
            'bindingKey' => 'id'

        ]);
        $this->hasMany('Postcommentfiles', [
            'className' => 'Postcommentfiles',
            'foreignKey' => 'comment_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Replyfiles', [
            'className' => 'Postcommentfiles',
            'foreignKey' => 'reply_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Groupposttagmembers', [
            'className' => 'Groupposttagmembers',
            'foreignKey' => 'comment_id',
            'bindingKey' => 'id'

        ]);

        $this->hasMany('Replytagmembers', [
            'className' => 'Groupposttagmembers',
            'foreignKey' => 'reply_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Postcommentlikes', [
            'className' => 'Postcommentlikes',
            'foreignKey' => 'comment_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Replylikes', [
            'className' => 'Postcommentlikes',
            'foreignKey' => 'reply_id',
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
            ->scalar('comment_data')
            ->maxLength('comment_data', 255)
            ->allowEmptyString('comment_data');

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
       // $rules->add($rules->existsIn(['user_id'], 'Users'));
       // $rules->add($rules->existsIn(['parent_id'], 'ParentPostcomments'));
     //   $rules->add($rules->existsIn(['group_id'], 'Groups'));
       // $rules->add($rules->existsIn(['post_id'], 'Posts'));

        return $rules;
    }
}
