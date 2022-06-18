<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsermodulePermissions Model
 *
 * @property \App\Model\Table\DesignationsTable|\Cake\ORM\Association\BelongsTo $Designations
 * @property \App\Model\Table\ModulesTable|\Cake\ORM\Association\BelongsTo $Modules
 *
 * @method \App\Model\Entity\UsermodulePermission get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsermodulePermission newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsermodulePermission[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsermodulePermission|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsermodulePermission saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsermodulePermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsermodulePermission[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsermodulePermission findOrCreate($search, callable $callback = null, $options = [])
 */
class UsermodulePermissionsTable extends Table
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

        $this->setTable('usermodule_permissions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Modules', [
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
            ->boolean('isAccessed')
            ->allowEmptyString('isAccessed', false);

        $validator
            ->boolean('isRead')
            ->allowEmptyString('isRead', false);

        $validator
            ->boolean('isWrite')
            ->allowEmptyString('isWrite', false);

        $validator
            ->boolean('isCreate')
            ->allowEmptyString('isCreate', false);

        $validator
            ->boolean('isDelete')
            ->allowEmptyString('isDelete', false);

        $validator
            ->boolean('isImport')
            ->allowEmptyString('isImport', false);

        $validator
            ->boolean('isExport')
            ->allowEmptyString('isExport', false);

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
       // $rules->add($rules->existsIn(['designation_id'], 'Designations'));
       // $rules->add($rules->existsIn(['module_id'], 'Modules'));

        return $rules;
    }
}
