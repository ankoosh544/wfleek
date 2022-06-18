<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projectemail Model
 *
 * @property \App\Model\Table\ProjectemailTable|\Cake\ORM\Association\BelongsTo $Projectemail
 * @property \App\Model\Table\ProjectemailTable|\Cake\ORM\Association\BelongsTo $Projectemail
 *
 * @method \App\Model\Entity\Projectemail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Projectemail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Projectemail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Projectemail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Projectemail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Projectemail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Projectemail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Projectemail findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectemailTable extends Table
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

        $this->setTable('projectemail');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Emailfiles', [
            'foreignKey' => 'email_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Tousers', [
            'className' => 'Touseremails',
            'foreignKey' => 'email_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Ccusers', [
            'className' => 'Projectccemails',
            'foreignKey' => 'email_id',
            'bindingKey' => 'id'
        ]);
        $this->hasMany('Bccusers', [
            'className' => 'Projectbccemails',
            'foreignKey' => 'email_id',
            'bindingKey' => 'id'
        ]);


        $this->hasMany('Replies', [
            'className' => 'Projectemail',
            'foreignKey' => 'parentemail_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Childmails', [
            'className' => 'Projectemail',
            'foreignKey' => 'rootmail_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('Forwardemails', [
            'className' => 'Projectemail',
            'foreignKey' => 'forwarded_id',
            'bindingKey' => 'id'
        ]);


        $this->belongsTo('FromUser', [
            'className' =>'User',
            'foreignKey' => 'fromuser_id',
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
            ->scalar('fromuser_email')
            ->maxLength('fromuser_email', 225)
            ->allowEmptyString('fromuser_email');

        $validator
            ->scalar('touser_email')
            ->maxLength('touser_email', 225)
            ->allowEmptyString('touser_email');

        $validator
            ->scalar('subject')
            ->allowEmptyString('subject');

        $validator
            ->scalar('body')
            ->maxLength('body', 500)
            ->allowEmptyString('body');

        $validator
            ->scalar('bcc')
            ->maxLength('bcc', 225)
            ->allowEmptyString('bcc');

        $validator
            ->scalar('cc')
            ->maxLength('cc', 225)
            ->allowEmptyString('cc');

        $validator
            ->dateTime('creation_date')
            ->allowEmptyDateTime('creation_date', false);

        $validator
            ->dateTime('send_date')
            ->allowEmptyDateTime('send_date', false);

        $validator
            ->boolean('isDeleted')
            ->allowEmptyString('isDeleted', false);

        $validator
            ->boolean('isSent')
            ->allowEmptyString('isSent', false);

        $validator
            ->boolean('isDraft')
            ->allowEmptyString('isDraft', false);

        $validator
            ->boolean('isStarred')
            ->allowEmptyString('isStarred', false);

        $validator
            ->scalar('worklabel')
            ->maxLength('worklabel', 1)
            ->allowEmptyString('worklabel');

        $validator
            ->boolean('isRead')
            ->allowEmptyString('isRead', false);

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
        //$rules->add($rules->existsIn(['parentemail_id'], 'Projectemail'));
       // $rules->add($rules->existsIn(['forwarded_id'], 'Projectemail'));

        return $rules;
    }
}
