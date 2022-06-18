<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Touseremails Model
 *
 * @property \App\Model\Table\ProjectemailTable|\Cake\ORM\Association\BelongsTo $Projectemail
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Touseremail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Touseremail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Touseremail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Touseremail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Touseremail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Touseremail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Touseremail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Touseremail findOrCreate($search, callable $callback = null, $options = [])
 */
class TouseremailsTable extends Table
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

        $this->setTable('touseremails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Projectemail', [
            'foreignKey' => 'email_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
            'className' => 'User',
            'foreignKey' => 'touser_id',
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
       // $rules->add($rules->existsIn(['email_id'], 'Projectemail'));
        //$rules->add($rules->existsIn(['touser_id'], 'User'));

        return $rules;
    }
}
