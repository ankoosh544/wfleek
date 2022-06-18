<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoiceitems Model
 *
 * @method \App\Model\Entity\Invoiceitem get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoiceitem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invoiceitem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoiceitem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoiceitem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoiceitem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoiceitem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoiceitem findOrCreate($search, callable $callback = null, $options = [])
 */
class InvoiceitemsTable extends Table
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

        $this->setTable('invoiceitems');
        $this->setDisplayField('itemId');
        $this->setPrimaryKey('itemId');

        $this->belongsTo('Taskgroups', [
            'foreignKey' => 'itemId'
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
            ->requirePresence('itemId', 'create')
            ->allowEmptyString('itemId', false);

        $validator
            ->requirePresence('invoiceId', 'create')
            ->allowEmptyString('invoiceId', false);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->allowEmptyString('quantity', false);

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->allowEmptyString('price', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        return $validator;
    }
}
