<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeShifts Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Usercompanies
 *
 * @method \App\Model\Entity\EmployeeShift get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeShift newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeShift[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeShift|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeShift saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeShift patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeShift[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeShift findOrCreate($search, callable $callback = null, $options = [])
 */
class EmployeeShiftsTable extends Table
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

        $this->setTable('employee_shifts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usercompanies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('RepeateShifts', [
            'foreignKey' => 'shift_id',
            'bindingKey' => 'id'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->allowEmptyDateTime('end_time');

        $validator
            ->boolean('isRepeated')
            ->allowEmptyString('isRepeated', false);

        $validator
            ->integer('weeks_to_repeat')
            ->allowEmptyString('weeks_to_repeat');

        $validator
            ->dateTime('endof_repeating_shift')
            ->allowEmptyDateTime('endof_repeating_shift');

        $validator
            ->boolean('isIndefinite')
            ->allowEmptyString('isIndefinite', false);

        $validator
            ->scalar('note')
            ->maxLength('note', 255)
            ->allowEmptyString('note');

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
