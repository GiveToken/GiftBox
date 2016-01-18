<?php
namespace Sizzle\Tests;

use \Sizzle\User;

/**
 * This class tests the User class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/UserTest
 */
class UserTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../util.php';
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new User();
        $this->assertEquals('Sizzle\User', get_class($result));
        $this->assertFalse(isset($result->email_address));
    }
}
