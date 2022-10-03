<?php

namespace App\Test\Cakephp\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BookmarksTable Test Case.
 *
 * @internal
 *
 * @coversNothing
 */
class BookmarksTableTest extends TestCase
{
    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        'app.bookmarks',
        'app.users',
        'app.apps',
        'app.profiles',
        'app.tags',
        'app.bookmarks_tags',
    ];

    /**
     * setUp method.
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::exists('Bookmarks') ? [] : ['className' => 'App\Model\Table\BookmarksTable'];
        $this->Bookmarks = TableRegistry::get('Bookmarks', $config);
    }

    /**
     * tearDown method.
     */
    public function tearDown(): void
    {
        unset($this->Bookmarks);

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

    /**
     * Test buildRules method.
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
