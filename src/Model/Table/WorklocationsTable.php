<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Worklocations Model
 *
 * @method \App\Model\Entity\Worklocation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Worklocation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Worklocation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Worklocation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Worklocation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Worklocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Worklocation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Worklocation findOrCreate($search, callable $callback = null, $options = [])
 */
class WorklocationsTable extends Table
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

        $this->setTable('worklocations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('work_location')
            ->maxLength('work_location', 250)
            ->allowEmptyString('work_location');

        $validator
            ->scalar('work_address')
            ->maxLength('work_address', 250)
            ->allowEmptyString('work_address');

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        return $validator;
    }
}
