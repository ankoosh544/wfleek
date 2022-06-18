<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notifications Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Companies
 * @property |\Cake\ORM\Association\BelongsTo $NotificationSettings
 * @property |\Cake\ORM\Association\BelongsTo $ModuleActions
 * @property |\Cake\ORM\Association\BelongsTo $Fromusers
 * @property |\Cake\ORM\Association\BelongsTo $Tousers
 *
 * @method \App\Model\Entity\Notification get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notification findOrCreate($search, callable $callback = null, $options = [])
 */
class NotificationsTable extends Table
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

        $this->setTable('notifications');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id'
        ]);
        $this->belongsTo('NotificationSettings', [
            'foreignKey' => 'module_id'
        ]);

        $this->belongsTo('Fromuser', [
            'className' => 'User',
            'foreignKey' => 'fromuser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Touser', [
            'className' => 'User',
            'foreignKey' => 'touser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Module', [
            'className' => 'CompanyModules',
            'foreignKey' => 'module_id',
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
            ->scalar('module_action')
            ->maxLength('module_action', 255)
            ->allowEmptyString('module_action');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->boolean('isSeen')
            ->allowEmptyString('isSeen');

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
      //  $rules->add($rules->existsIn(['module_id'], 'NotificationSettings'));
      //  $rules->add($rules->existsIn(['module_action_id'], 'ModuleActions'));
      //  $rules->add($rules->existsIn(['fromuser_id'], 'Fromusers'));
       // $rules->add($rules->existsIn(['touser_id'], 'Tousers'));

        return $rules;
    }
}
