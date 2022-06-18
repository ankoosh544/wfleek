<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usercompanies Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Usercompany get($primaryKey, $options = [])
 * @method \App\Model\Entity\Usercompany newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Usercompany[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Usercompany|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usercompany saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usercompany patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Usercompany[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Usercompany findOrCreate($search, callable $callback = null, $options = [])
 */
class UsercompaniesTable extends Table
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

        $this->setTable('usercompanies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
         $this->belongsTo('Companyuser', [
            'className' => 'User',
            'foreignKey' => 'company_user',
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
            ->requirePresence('company_user', 'create')
            ->allowEmptyString('company_user', false);

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->scalar('address')
            ->maxLength('address', 250)
            ->allowEmptyString('address');

        $validator
            ->scalar('country')
            ->maxLength('country', 150)
            ->allowEmptyString('country');

        $validator
            ->scalar('city')
            ->maxLength('city', 150)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 150)
            ->allowEmptyString('state');

        $validator
            ->integer('postal_code')
            ->allowEmptyString('postal_code');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 150)
            ->allowEmptyString('phone_number');

        $validator
            ->scalar('mobile_number')
            ->maxLength('mobile_number', 150)
            ->allowEmptyString('mobile_number');

        $validator
            ->scalar('iban')
            ->maxLength('iban', 150)
            ->allowEmptyString('iban');

        $validator
            ->scalar('website')
            ->maxLength('website', 250)
            ->allowEmptyString('website');

        $validator
            ->scalar('company_logoFilepath')
            ->maxLength('company_logoFilepath', 250)
            ->allowEmptyString('company_logoFilepath');

        $validator
            ->scalar('company_logoFilename')
            ->maxLength('company_logoFilename', 250)
            ->allowEmptyString('company_logoFilename');

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
       // $rules->add($rules->isUnique(['email']));
       // $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
