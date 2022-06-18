<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Postcommentlikes Model
 *
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\BelongsTo $Comments
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property |\Cake\ORM\Association\BelongsTo $Postcomments
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Postcommentlike get($primaryKey, $options = [])
 * @method \App\Model\Entity\Postcommentlike newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Postcommentlike[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Postcommentlike|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postcommentlike saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postcommentlike patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Postcommentlike[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Postcommentlike findOrCreate($search, callable $callback = null, $options = [])
 */
class PostcommentlikesTable extends Table
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

        $this->setTable('postcommentlikes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Comments', [
            'foreignKey' => 'comment_id'
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id'
        ]);
        $this->belongsTo('Postcomments', [
            'foreignKey' => 'reply_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'user_id'
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
            ->boolean('isLiked')
            ->allowEmptyString('isLiked', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

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
       // $rules->add($rules->existsIn(['comment_id'], 'Comments'));
       // $rules->add($rules->existsIn(['post_id'], 'Posts'));
        //$rules->add($rules->existsIn(['reply_id'], 'Postcomments'));
       // $rules->add($rules->existsIn(['group_id'], 'Groups'));
       // $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
