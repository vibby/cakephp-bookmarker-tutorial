<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tags Model.
 *
 * @property \Cake\ORM\Association\BelongsToMany $Bookmarks
 */
class TagsTable extends Table
{
    /**
     * Initialize method.
     *
     * @param array $config the configuration for the Table
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tags');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Bookmarks', [
            'foreignKey' => 'tag_id',
            'targetForeignKey' => 'bookmark_id',
            'joinTable' => 'bookmarks_tags',
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
            ->allowEmpty('title')
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
        ;

        return $validator;
    }
}
