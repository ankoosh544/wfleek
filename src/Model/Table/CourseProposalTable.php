<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseProposal Model
 *
 * @method \App\Model\Entity\CourseProposal get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseProposal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseProposal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseProposal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseProposal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseProposal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseProposal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseProposal findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseProposalTable extends Table
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

        $this->setTable('course_proposal');
        $this->setDisplayField('id');
        $this->setPrimaryKey('projectId', 'organizationId');
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
            ->allowEmptyString('organizationId');

        $validator
            ->integer('priceMin')
            ->allowEmptyString('priceMin');

        $validator
            ->integer('priceMax')
            ->allowEmptyString('priceMax');

        return $validator;
    }
}
