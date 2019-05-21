<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\UserGeneratePassComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\UserGeneratePassComponent Test Case
 */
class UserGeneratePassComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\UserGeneratePassComponent
     */
    public $UserGeneratePass;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->UserGeneratePass = new UserGeneratePassComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserGeneratePass);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
