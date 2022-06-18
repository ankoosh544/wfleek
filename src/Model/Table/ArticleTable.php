<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Article Model
 *
 * @method \App\Model\Entity\Article get($primaryKey, $options = [])
 * @method \App\Model\Entity\Article newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Article|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Article[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Article findOrCreate($search, callable $callback = null, $options = [])
 */
class ArticleTable extends Table
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

        $this->setTable('article');
        $this->setDisplayField('name');
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
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', false);

        $validator
            ->scalar('type')
            ->maxLength('type', 1)
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->scalar('name')
            ->maxLength('name', 70)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->boolean('isVirtualQty')
            ->allowEmptyString('isVirtualQty');

        $validator
            ->boolean('isObsolete')
            ->allowEmptyString('isObsolete');

        $validator
            ->scalar('um')
            ->maxLength('um', 3)
            ->requirePresence('um', 'create')
            ->allowEmptyString('um', false);

        $validator
            ->scalar('umPack')
            ->maxLength('umPack', 3)
            ->allowEmptyString('umPack');

        $validator
            ->integer('packQty')
            ->allowEmptyString('packQty');

        $validator
            ->allowEmptyString('singleArticleId');

        $validator
            ->scalar('grp')
            ->maxLength('grp', 5)
            ->allowEmptyString('grp');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
