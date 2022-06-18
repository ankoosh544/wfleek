<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dailyattendencepdfs Model
 *
 * @property \App\Model\Table\CompaniesTable|\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\Dailyattendencepdf get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dailyattendencepdf findOrCreate($search, callable $callback = null, $options = [])
 */
class DailyattendencepdfsTable extends Table
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

        $this->setTable('dailyattendencepdfs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id'
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
            ->scalar('month')
            ->maxLength('month', 255)
            ->allowEmptyString('month');

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 255)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyFile('filename');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

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
       // $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
