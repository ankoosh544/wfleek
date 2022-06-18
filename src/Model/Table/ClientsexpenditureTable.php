<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clientsexpenditure Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Clientsexpenditure get($primaryKey, $options = [])
 * @method \App\Model\Entity\Clientsexpenditure newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Clientsexpenditure[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Clientsexpenditure|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clientsexpenditure saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clientsexpenditure patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Clientsexpenditure[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Clientsexpenditure findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientsexpenditureTable extends Table
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

        $this->setTable('clientsexpenditure');
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
            ->scalar('typeof_transport')
            ->maxLength('typeof_transport', 250)
            ->allowEmptyString('typeof_transport');

        $validator
            ->scalar('transportation_file')
            ->maxLength('transportation_file', 250)
            ->allowEmptyFile('transportation_file');

        $validator
            ->scalar('accomodation_hotel_name')
            ->maxLength('accomodation_hotel_name', 250)
            ->allowEmptyString('accomodation_hotel_name');

        $validator
            ->scalar('accomodation_file')
            ->maxLength('accomodation_file', 250)
            ->allowEmptyFile('accomodation_file');

        $validator
            ->scalar('restaurant_name')
            ->maxLength('restaurant_name', 250)
            ->allowEmptyString('restaurant_name');

        $validator
            ->scalar('restaurant_file')
            ->maxLength('restaurant_file', 250)
            ->allowEmptyFile('restaurant_file');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
