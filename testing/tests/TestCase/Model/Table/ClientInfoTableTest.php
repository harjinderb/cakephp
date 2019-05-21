<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientInfoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientInfoTable Test Case
 */
class ClientInfoTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientInfoTable
     */
    public $ClientInfo;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.client_info'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClientInfo') ? [] : ['className' => ClientInfoTable::class];
        $this->ClientInfo = TableRegistry::getTableLocator()->get('ClientInfo', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientInfo);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
