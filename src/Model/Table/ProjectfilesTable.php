<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projectfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $ProjectObject
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Projectfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Projectfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Projectfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Projectfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Projectfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Projectfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Projectfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Projectfile findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectfilesTable extends Table
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

        $this->setTable('projectfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProjectObject', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
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
            ->scalar('filename')
            ->maxLength('filename', 50)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 250)
            ->allowEmptyFile('filepath');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->scalar('type')
            ->maxLength('type', 250)
            ->allowEmptyString('type');

        $validator
            ->integer('size')
            ->allowEmptyString('size');

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        $validator
            ->scalar('temp')
            ->maxLength('temp', 150)
            ->allowEmptyString('temp');

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
        $rules->add($rules->existsIn(['project_id'], 'ProjectObject'));
        $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
