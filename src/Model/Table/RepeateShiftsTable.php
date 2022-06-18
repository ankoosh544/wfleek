<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RepeateShifts Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $EmployeeShifts
 *
 * @method \App\Model\Entity\RepeateShift get($primaryKey, $options = [])
 * @method \App\Model\Entity\RepeateShift newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RepeateShift[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RepeateShift|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RepeateShift saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RepeateShift patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RepeateShift[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RepeateShift findOrCreate($search, callable $callback = null, $options = [])
 */
class RepeateShiftsTable extends Table
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

        $this->setTable('repeate_shifts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('EmployeeShifts', [
            'foreignKey' => 'shift_id',
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
            ->integer('weeks_of_repeat')
            ->requirePresence('weeks_of_repeat', 'create')
            ->allowEmptyString('weeks_of_repeat', false);

        $validator
            ->scalar('dayname')
            ->maxLength('dayname', 255)
            ->allowEmptyString('dayname');

        $validator
            ->dateTime('endof_repeating_shift')
            ->allowEmptyDateTime('endof_repeating_shift');

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
        //$rules->add($rules->existsIn(['shift_id'], 'EmployeeShifts'));

        return $rules;
    }
}
