<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompaniesUser Model
 *
 * @property \App\Model\Table\UsercompaniesTable|\Cake\ORM\Association\BelongsTo $Usercompanies
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CompaniesUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompaniesUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompaniesUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompaniesUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompaniesUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompaniesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompaniesUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompaniesUser findOrCreate($search, callable $callback = null, $options = [])
 */
class CompaniesUserTable extends Table
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

        $this->setTable('companies_user');
        $this->setDisplayField('company_id');
        $this->setPrimaryKey(['company_id', 'user_id']);

        $this->belongsTo('Usercompanies', [
            'className' => 'Usercompanies',
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->hasOne('ProjectMember', [
            'foreignKey' => 'memberId',
            'bindingKey' => 'user_id'
        ]);

        $this->hasOne('Payslips', [
            'foreignKey' => 'company_id',
            'bindingKey' => 'company_id'
        ]);

        $this->hasMany('Workinghours', [
            'foreignKey' => 'company_id',
            'bindingKey' => 'company_id'
        ]);
        $this->hasMany('Leaves',[
            'foreignKey' => 'company_id',
            'bindingKey' => 'company_id'
        ]);

        $this->belongsTo('Designations',[
            'foreignKey' => 'member_role',
            'joinType' => 'INNER'

        ]);
        $this->hasMany('Invoices',[
            'foreignKey' => 'company_id',
            'bindingKey' => 'company_id'
        ]);
        $this->hasMany('Shiftschedules',[
            'foreignKey' => 'user_id',
            'bindingKey' => 'user_id'
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
            ->scalar('member_role')
            ->maxLength('member_role', 1)
            ->allowEmptyString('member_role');

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
      //  $rules->add($rules->existsIn(['company_id'], 'Usercompanies'));
     //   $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
