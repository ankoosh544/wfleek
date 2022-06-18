<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Additionaldatausers Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Usercompanies
 *
 * @method \App\Model\Entity\Additionaldatauser get($primaryKey, $options = [])
 * @method \App\Model\Entity\Additionaldatauser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Additionaldatauser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Additionaldatauser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Additionaldatauser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Additionaldatauser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Additionaldatauser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Additionaldatauser findOrCreate($search, callable $callback = null, $options = [])
 */
class AdditionaldatausersTable extends Table
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

        $this->setTable('additionaldatausers');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');

        $this->belongsTo('Usercompanies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Designations',[
            'foreignKey' => 'member_role',
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
            ->allowEmptyString('user_id', 'create');

        $validator
            ->scalar('member_role')
            ->maxLength('member_role', 1)
            ->allowEmptyString('member_role');

        $validator
            ->scalar('vat_code')
            ->maxLength('vat_code', 250)
            ->allowEmptyString('vat_code');

        $validator
            ->scalar('tax_code')
            ->maxLength('tax_code', 250)
            ->allowEmptyString('tax_code');

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
       // $rules->add($rules->existsIn(['company_id'], 'Usercompanies'));

        return $rules;
    }
}
