<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Anagraphic Model
 *
 * @method \App\Model\Entity\Anagraphic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Anagraphic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Anagraphic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Anagraphic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Anagraphic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Anagraphic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Anagraphic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Anagraphic findOrCreate($search, callable $callback = null, $options = [])
 */
class AnagraphicTable extends Table
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

        $this->setTable('anagraphic');
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
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->scalar('name1')
            ->maxLength('name1', 100)
            ->requirePresence('name1', 'create')
            ->allowEmptyString('name1', false);

        $validator
            ->scalar('name2')
            ->maxLength('name2', 100)
            ->allowEmptyString('name2');

        $validator
            ->scalar('codFiscale')
            ->maxLength('codFiscale', 16)
            ->allowEmptyString('codFiscale');

        $validator
            ->scalar('pIva')
            ->maxLength('pIva', 16)
            ->allowEmptyString('pIva');

        $validator
            ->boolean('isPhysicalPerson')
            ->allowEmptyString('isPhysicalPerson');

        $validator
            ->boolean('isPrivateCitizen')
            ->allowEmptyString('isPrivateCitizen');

        $validator
            ->boolean('isSchool')
            ->allowEmptyString('isSchool');

        $validator
            ->scalar('specialType')
            ->maxLength('specialType', 3)
            ->allowEmptyString('specialType');

        $validator
            ->scalar('sex')
            ->maxLength('sex', 1)
            ->allowEmptyString('sex');

        $validator
            ->date('birthDate')
            ->allowEmptyDate('birthDate');

        $validator
            ->scalar('birthPlace')
            ->maxLength('birthPlace', 70)
            ->allowEmptyString('birthPlace');

        $validator
            ->scalar('birthProvince')
            ->maxLength('birthProvince', 2)
            ->allowEmptyString('birthProvince');

        $validator
            ->scalar('birthCountry')
            ->maxLength('birthCountry', 2)
            ->allowEmptyString('birthCountry');

        $validator
            ->boolean('isPIvaVerified')
            ->allowEmptyString('isPIvaVerified');

        $validator
            ->boolean('isNonResidentCF')
            ->allowEmptyString('isNonResidentCF');

        $validator
            ->scalar('pec')
            ->maxLength('pec', 100)
            ->allowEmptyString('pec');

        $validator
            ->scalar('ftp')
            ->maxLength('ftp', 100)
            ->allowEmptyString('ftp');

        $validator
            ->scalar('web')
            ->maxLength('web', 100)
            ->allowEmptyString('web');

        $validator
            ->boolean('isAuthPersonalData')
            ->allowEmptyString('isAuthPersonalData');

        $validator
            ->allowEmptyString('fatherId');

        $validator
            ->scalar('langId')
            ->maxLength('langId', 2)
            ->requirePresence('langId', 'create')
            ->allowEmptyString('langId', false);

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        return $validator;
    }
}
