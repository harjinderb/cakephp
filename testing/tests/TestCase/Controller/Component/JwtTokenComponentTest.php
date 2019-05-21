<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\JwtTokenComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\JwtTokenComponent Test Case
 */
class JwtTokenComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\JwtTokenComponent
     */
    public $JwtToken;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->JwtToken = new JwtTokenComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->JwtToken);

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
