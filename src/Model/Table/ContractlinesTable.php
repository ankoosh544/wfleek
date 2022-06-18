<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contractlines Model
 *
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\Contractline get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contractline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Contractline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contractline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contractline saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contractline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contractline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contractline findOrCreate($search, callable $callback = null, $options = [])
 */
class ContractlinesTable extends Table
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

        $this->setTable('contractlines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id'
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
            ->scalar('grouptitle')
            ->allowEmptyString('grouptitle');

        $validator
            ->scalar('tasktitle')
            ->allowEmptyString('tasktitle');

        $validator
            ->scalar('description_task')
            ->maxLength('description_task', 16777215)
            ->allowEmptyString('description_task');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->allowEmptyString('price', false);

        $validator
            ->decimal('tax_percentage')
            ->requirePresence('tax_percentage', 'create')
            ->allowEmptyString('tax_percentage', false);

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
        $rules->add($rules->existsIn(['contract_id'], 'Contracts'));

        return $rules;
    }
}
