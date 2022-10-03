<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model.
 *
 * @property \Cake\ORM\Association\HasMany $Apps
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 * @property \Cake\ORM\Association\HasMany $Profiles
 */
class UsersTable extends Table
{
    /**
     * Initialize method.
     *
     * @param array $config the configuration for the Table
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Apps', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Bookmarks', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator validator instance
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
        ;

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email')
        ;

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password')
        ;

        $validator
            ->add('dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('dob')
        ;

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules the rules object to be modified
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
