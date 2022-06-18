<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Postcommentfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Groupposts
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\BelongsTo $Comments
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property |\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Postcommentfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Postcommentfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Postcommentfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Postcommentfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postcommentfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Postcommentfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Postcommentfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Postcommentfile findOrCreate($search, callable $callback = null, $options = [])
 */
class PostcommentfilesTable extends Table
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

        $this->setTable('postcommentfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groupposts', [
            'foreignKey' => 'post_id'
        ]);
        $this->belongsTo('Comments', [
            'foreignKey' => 'comment_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('User', [
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
            ->scalar('filepath')
            ->maxLength('filepath', 255)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyFile('filename');

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
       // $rules->add($rules->existsIn(['post_id'], 'Groupposts'));
       // $rules->add($rules->existsIn(['comment_id'], 'Comments'));
        //$rules->add($rules->existsIn(['group_id'], 'Groups'));
       // $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
