<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groupfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Groupfileposts
 *
 * @method \App\Model\Entity\Groupfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Groupfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Groupfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Groupfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Groupfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Groupfile findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupfilesTable extends Table
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

        $this->setTable('groupfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groupfileposts', [
            'foreignKey' => 'groupfilepost_id'
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
            ->maxLength('filename', 255)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 255)
            ->allowEmptyFile('filepath');

        $validator
            ->allowEmptyString('size');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

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
        $rules->add($rules->existsIn(['groupfilepost_id'], 'Groupfileposts'));

        return $rules;
    }
}
