<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Futuretaskgroup Model
 *
 * @method \App\Model\Entity\Futuretaskgroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Futuretaskgroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Futuretaskgroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Futuretaskgroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Futuretaskgroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Futuretaskgroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Futuretaskgroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Futuretaskgroup findOrCreate($search, callable $callback = null, $options = [])
 */
class FuturetaskgroupTable extends Table
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

        $this->setTable('futuretaskgroup');
        $this->setDisplayField('title');
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
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->decimal('tax_percentage')
            ->allowEmptyString('tax_percentage');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date');

        $validator
            ->dateTime('last_update')
            ->allowEmptyDateTime('last_update');

        $validator
            ->dateTime('startdate')
            ->allowEmptyDateTime('startdate');

        $validator
            ->dateTime('expirydate')
            ->allowEmptyDateTime('expirydate');

        return $validator;
    }
}
