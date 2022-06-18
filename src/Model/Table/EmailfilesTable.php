<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Emailfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Projectemail
 * @property \App\Model\Table\FromusersTable|\Cake\ORM\Association\BelongsTo $Fromusers
 * @property \App\Model\Table\TousersTable|\Cake\ORM\Association\BelongsTo $Tousers
 *
 * @method \App\Model\Entity\Emailfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Emailfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Emailfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Emailfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Emailfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Emailfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Emailfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Emailfile findOrCreate($search, callable $callback = null, $options = [])
 */
class EmailfilesTable extends Table
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

        $this->setTable('emailfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Projectemail', [
            'foreignKey' => 'parentemail_id'
        ]);
        $this->belongsTo('Fromusers', [
            'foreignKey' => 'fromuser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tousers', [
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
            ->scalar('filepath')
            ->maxLength('filepath', 250)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 250)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('type')
            ->maxLength('type', 250)
            ->allowEmptyString('type');

        $validator
            ->allowEmptyString('size');

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
       // $rules->add($rules->existsIn(['parentemail_id'], 'Projectemail'));
      //  $rules->add($rules->existsIn(['fromuser_id'], 'Fromusers'));
      //  $rules->add($rules->existsIn(['touser_id'], 'Tousers'));

        return $rules;
    }
}
