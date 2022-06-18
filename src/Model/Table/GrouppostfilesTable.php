<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Grouppostfiles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\GrouppostsTable|\Cake\ORM\Association\BelongsTo $Groupposts
 *
 * @method \App\Model\Entity\Grouppostfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Grouppostfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Grouppostfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Grouppostfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grouppostfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grouppostfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Grouppostfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Grouppostfile findOrCreate($search, callable $callback = null, $options = [])
 */
class GrouppostfilesTable extends Table
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

        $this->setTable('grouppostfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'className' => 'User',
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Groupposts', [
            'foreignKey' => 'grouppost_id'
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
            ->maxLength('filepath', 255)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyFile('filename');

        $validator
            ->allowEmptyString('size');

        $validator
            ->boolean('isDeleted')
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
      //  $rules->add($rules->existsIn(['user_id'], 'Users'));
      //  $rules->add($rules->existsIn(['group_id'], 'Groups'));
      //  $rules->add($rules->existsIn(['grouppost_id'], 'Groupposts'));

        return $rules;
    }
}
