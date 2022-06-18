<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShiftSchedules Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $CompaniesUser
 * @property \App\Model\Table\DepartmentsTable|\Cake\ORM\Association\BelongsTo $Departments
 * @property |\Cake\ORM\Association\BelongsTo $User
 * @property |\Cake\ORM\Association\BelongsTo $EmployeeShifts
 *
 * @method \App\Model\Entity\ShiftSchedule get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShiftSchedule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShiftSchedule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShiftSchedule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShiftSchedule saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShiftSchedule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShiftSchedule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShiftSchedule findOrCreate($search, callable $callback = null, $options = [])
 */
class ShiftSchedulesTable extends Table
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

        $this->setTable('shift_schedules');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CompaniesUser', [
            'foreignKey' => 'company_id'
        ]);
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id'
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('EmployeeShifts', [
            'foreignKey' => 'shift_id'
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
            ->dateTime('scheduledshift_startdate')
            ->allowEmptyDateTime('scheduledshift_startdate');

        $validator
            ->dateTime('scheduledshift_enddate')
            ->allowEmptyDateTime('scheduledshift_enddate');

        $validator
            ->boolean('isAcceptExtrahrs')
            ->allowEmptyString('isAcceptExtrahrs', false);

        $validator
            ->boolean('isPublish')
            ->allowEmptyString('isPublish', false);

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
       // $rules->add($rules->existsIn(['company_id'], 'CompaniesUser'));
       // $rules->add($rules->existsIn(['department_id'], 'Departments'));
       // $rules->add($rules->existsIn(['user_id'], 'User'));
       // $rules->add($rules->existsIn(['shift_id'], 'EmployeeShifts'));

        return $rules;
    }
}
