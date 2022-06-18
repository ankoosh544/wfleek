<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Userbanks Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Userbank get($primaryKey, $options = [])
 * @method \App\Model\Entity\Userbank newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Userbank[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Userbank|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Userbank saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Userbank patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Userbank[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Userbank findOrCreate($search, callable $callback = null, $options = [])
 */
class UserbanksTable extends Table
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

        $this->setTable('userbanks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
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
            ->scalar('bank_name')
            ->maxLength('bank_name', 255)
            ->allowEmptyString('bank_name');

        $validator
            ->scalar('iban')
            ->maxLength('iban', 255)
            ->allowEmptyString('iban');

        $validator
            ->scalar('state_bankbranch')
            ->maxLength('state_bankbranch', 255)
            ->allowEmptyString('state_bankbranch');

        $validator
            ->scalar('city_bankbranch')
            ->maxLength('city_bankbranch', 255)
            ->allowEmptyString('city_bankbranch');

        $validator
            ->scalar('province_bankbranch')
            ->maxLength('province_bankbranch', 255)
            ->allowEmptyString('province_bankbranch');

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
        //$rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
