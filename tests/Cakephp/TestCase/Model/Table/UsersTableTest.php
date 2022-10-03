<?php

namespace App\Test\Cakephp\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case.
 *
 * @internal
 *
 * @coversNothing
 */
class UsersTableTest extends TestCase
{
    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.apps',
        'app.bookmarks',
        'app.profiles',
    ];

    /**
     * setUp method.
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'App\Model\Table\UsersTable'];
        $this->Users = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method.
     */
    public function tearDown(): void
    {
        unset($this->Users);

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
