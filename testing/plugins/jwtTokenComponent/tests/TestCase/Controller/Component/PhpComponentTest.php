<?php
namespace jwtTokenComponent\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use jwtTokenComponent\Controller\Component\PhpComponent;

/**
 * jwtTokenComponent\Controller\Component\PhpComponent Test Case
 */
class PhpComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \jwtTokenComponent\Controller\Component\PhpComponent
     */
    public $Php;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Php = new PhpComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Php);

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
