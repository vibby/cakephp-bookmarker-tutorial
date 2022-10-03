<?php

namespace App\Test\Cakephp\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TagsTable Test Case.
 *
 * @internal
 *
 * @coversNothing
 */
class TagsTableTest extends TestCase
{
    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        'app.tags',
        'app.bookmarks',
        'app.users',
        'app.apps',
        'app.profiles',
        'app.bookmarks_tags',
    ];

    /**
     * setUp method.
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::exists('Tags') ? [] : ['className' => 'App\Model\Table\TagsTable'];
        $this->Tags = TableRegistry::get('Tags', $config);
    }

    /**
     * tearDown method.
     */
    public function tearDown(): void
    {
        unset($this->Tags);

        parent::tearDown();
    }

    /**
     * Test initialize method.
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method.
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
