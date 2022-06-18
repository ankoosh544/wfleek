<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groupnotes Model
 *
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\Groupnote get($primaryKey, $options = [])
 * @method \App\Model\Entity\Groupnote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Groupnote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Groupnote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupnote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Groupnote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Groupnote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Groupnote findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupnotesTable extends Table
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

        $this->setTable('groupnotes');
        $this->setDisplayField('post_id');
        $this->setPrimaryKey('post_id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Groupposts', [
            'foreignKey' => 'post_id'
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
            ->allowEmptyString('post_id', 'create');

        $validator
            ->scalar('post_data')
            ->allowEmptyString('post_data');

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
       // $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }
}
