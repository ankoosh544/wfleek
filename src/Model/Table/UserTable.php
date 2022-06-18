<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * User Model
 *
 * @property |\Cake\ORM\Association\HasMany $Chatgroupsusers
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\EGivenAnswersTable|\Cake\ORM\Association\HasMany $EGivenAnswers
 * @property \App\Model\Table\ELessonCompletedTable|\Cake\ORM\Association\HasMany $ELessonCompleted
 * @property \App\Model\Table\LeavesTable|\Cake\ORM\Association\HasMany $Leaves
 * @property \App\Model\Table\OrganizatioUsersYearsTable|\Cake\ORM\Association\HasMany $OrganizatioUsersYears
 * @property \App\Model\Table\OrganizationRolesTable|\Cake\ORM\Association\HasMany $OrganizationRoles
 * @property \App\Model\Table\SchoolTranscriptsTable|\Cake\ORM\Association\HasMany $SchoolTranscripts
 * @property \App\Model\Table\SlRolesTable|\Cake\ORM\Association\HasMany $SlRoles
 * @property \App\Model\Table\SupportEmailsTable|\Cake\ORM\Association\HasMany $SupportEmails
 * @property \App\Model\Table\ECourseTable|\Cake\ORM\Association\BelongsToMany $ECourse
 * @property \App\Model\Table\OrganizationTable|\Cake\ORM\Association\BelongsToMany $Organization
 * @property \App\Model\Table\RoleTable|\Cake\ORM\Association\BelongsToMany $Role
 * @property \App\Model\Table\SubscriptionTable|\Cake\ORM\Association\BelongsToMany $Subscription
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UserTable extends Table
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

        $this->setTable('user');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Chatgroupsusers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('EGivenAnswers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ELessonCompleted', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Leaves', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OrganizatioUsersYears', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OrganizationRoles', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SchoolTranscripts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SlRoles', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SupportEmails', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('ECourse', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'e_course_id',
            'joinTable' => 'e_course_user'
        ]);
        $this->belongsToMany('Organization', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'organization_id',
            'joinTable' => 'organization_user'
        ]);
        $this->belongsToMany('Role', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'user_role'
        ]);
        $this->belongsToMany('Subscription', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'subscription_id',
            'joinTable' => 'user_subscription'
        ]);
        $this->hasOne('Authusercompany', [
            'className' => 'Usercompanies',
            'foreignKey' => 'id',
            'bindingKey' => 'choosen_companyId'
        ]);
        $this->hasOne('Companiesuser', [
            'className' => 'CompaniesUser',
            'foreignKey' => 'company_id',
            'bindingKey' => 'choosen_companyId'
        ]);
        $this->hasOne('Additionaldatausers', [
            'className' => 'Additionaldatausers',
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Workinghours', [
            'className' => 'Workinghours',
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Authuserprojects', [
            'className' => 'ProjectMember',
            'foreignKey' => 'memberId',
            'bindingKey' => 'id'
        ]);
        $this->hasOne('Userbanks', [
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
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
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted');

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 100)
            ->allowEmptyString('firstname');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 100)
            ->allowEmptyString('lastname');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->allowEmptyString('email', false)
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('email2')
            ->maxLength('email2', 100)
            ->allowEmptyString('email2');

        $validator
            ->scalar('langId')
            ->maxLength('langId', 2)
            ->requirePresence('langId', 'create')
            ->allowEmptyString('langId', false);

        $validator
            ->scalar('username')
            ->maxLength('username', 70)
            ->requirePresence('username', 'create')
            ->allowEmptyString('username', false)
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 245)
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->date('passwordExpirationDate')
            ->requirePresence('passwordExpirationDate', 'create')
            ->allowEmptyDate('passwordExpirationDate', false);

        $validator
            ->dateTime('lastChangePwdTime')
            ->allowEmptyDateTime('lastChangePwdTime');

        $validator
            ->boolean('isOrganization')
            ->allowEmptyString('isOrganization');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 70)
            ->requirePresence('nickname', 'create')
            ->allowEmptyString('nickname', false)
            ->add('nickname', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('isBlocked')
            ->allowEmptyString('isBlocked');

        $validator
            ->scalar('blockReason')
            ->maxLength('blockReason', 200)
            ->allowEmptyString('blockReason');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 100)
            ->allowEmptyString('tel');

        $validator
            ->dateTime('registrationDate')
            ->allowEmptyDateTime('registrationDate');

        $validator
            ->date('expirationDate')
            ->allowEmptyDate('expirationDate');

        $validator
            ->dateTime('lastUpdate')
            ->allowEmptyDateTime('lastUpdate');

        $validator
            ->scalar('imageFileName')
            ->maxLength('imageFileName', 255)
            ->allowEmptyFile('imageFileName');

        $validator
            ->scalar('imageFilePath')
            ->maxLength('imageFilePath', 255)
            ->allowEmptyFile('imageFilePath');

        $validator
            ->allowEmptyFile('image');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        $validator
            ->allowEmptyString('anagId');

        $validator
            ->boolean('isReferral')
            ->allowEmptyString('isReferral');

        $validator
            ->allowEmptyString('referralPrivateUserId');

        $validator
            ->integer('level')
            ->allowEmptyString('level');

        $validator
            ->boolean('isAuthByReferral')
            ->allowEmptyString('isAuthByReferral');

        $validator
            ->dateTime('birthday')
            ->allowEmptyDateTime('birthday');

        $validator
            ->scalar('address')
            ->maxLength('address', 250)
            ->allowEmptyString('address');

        $validator
            ->scalar('country')
            ->maxLength('country', 250)
            ->allowEmptyString('country');

        $validator
            ->scalar('state')
            ->maxLength('state', 250)
            ->allowEmptyString('state');

        $validator
            ->integer('cap')
            ->requirePresence('cap', 'create')
            ->allowEmptyString('cap', false);

        $validator
            ->scalar('gender')
            ->allowEmptyString('gender');

        $validator
            ->integer('resetpasswordcode')
            ->allowEmptyString('resetpasswordcode');

        $validator
            ->scalar('tags')
            ->allowEmptyString('tags');

        $validator
            ->scalar('profileFilename')
            ->maxLength('profileFilename', 225)
            ->allowEmptyFile('profileFilename');

        $validator
            ->scalar('profileFilepath')
            ->maxLength('profileFilepath', 225)
            ->allowEmptyFile('profileFilepath');

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
        //$rules->add($rules->isUnique(['email']));
        //$rules->add($rules->isUnique(['username']));
       // $rules->add($rules->isUnique(['nickname']));

        return $rules;
    }
}
