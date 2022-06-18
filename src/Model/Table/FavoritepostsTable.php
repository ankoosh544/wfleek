<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Favoriteposts Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Favoritepost get($primaryKey, $options = [])
 * @method \App\Model\Entity\Favoritepost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Favoritepost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Favoritepost|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Favoritepost saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Favoritepost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Favoritepost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Favoritepost findOrCreate($search, callable $callback = null, $options = [])
 */
class FavoritepostsTable extends Table
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

        $this->setTable('favoriteposts');
        $this->setDisplayField('post_id');
        $this->setPrimaryKey('post_id');

        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Posts', [
            'className' => 'Groupposts',
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
            ->allowEmptyString('post_id', 'create');

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
        //$rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
