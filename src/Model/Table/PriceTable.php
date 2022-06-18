<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Price Model
 *
 * @method \App\Model\Entity\Price get($primaryKey, $options = [])
 * @method \App\Model\Entity\Price newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Price[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Price|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Price saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Price patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Price[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Price findOrCreate($search, callable $callback = null, $options = [])
 */
class PriceTable extends Table
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

        $this->setTable('price');
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
            ->requirePresence('articleId', 'create')
            ->allowEmptyString('articleId', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->decimal('sellPrice')
            ->requirePresence('sellPrice', 'create')
            ->allowEmptyString('sellPrice', false);

        $validator
            ->decimal('tax')
            ->requirePresence('tax', 'create')
            ->allowEmptyString('tax', false);

        $validator
            ->decimal('netPrice')
            ->requirePresence('netPrice', 'create')
            ->allowEmptyString('netPrice', false);

        $validator
            ->decimal('discount1')
            ->allowEmptyString('discount1');

        $validator
            ->decimal('discount2')
            ->allowEmptyString('discount2');

        $validator
            ->scalar('currencyCode')
            ->maxLength('currencyCode', 3)
            ->requirePresence('currencyCode', 'create')
            ->allowEmptyString('currencyCode', false);

        $validator
            ->dateTime('startDate')
            ->requirePresence('startDate', 'create')
            ->allowEmptyDateTime('startDate', false);

        $validator
            ->dateTime('endDate')
            ->allowEmptyDateTime('endDate');

        $validator
            ->scalar('priceListId')
            ->maxLength('priceListId', 2)
            ->allowEmptyString('priceListId');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
