<?php
namespace Sizzle\Tests;

use \Sizzle\Database\{
    EmailCredential,
    User
};

/**
 * This class tests the EmailCredential class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Database/EmailCredentialTest
 */
class EmailCredentialTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    /**
     * Creates test user
     */
    public function setUp()
    {
        // setup test user
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $this->User = $User;
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // no params
        $result = new EmailCredential();
        $this->assertEquals('Sizzle\Database\EmailCredential', get_class($result));

        // test with bad id
        $result2 = new EmailCredential(-1);
        $this->assertFalse(isset($result2->id));

        // test with good id in testCreate() below
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // Info for email credentials
        $user_id = $this->User->id;
        $username = 'user'.rand();
        $password = 'my'.rand();
        $smtp_host = rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255);
        $smtp_port = rand(1, 1000);

        // Create credentials
        $EmailCredential = new EmailCredential();
        $id = $EmailCredential->create($user_id, $username, $password, $smtp_host, $smtp_port);

        // Check class variables set
        $this->assertEquals($EmailCredential->id, $id);
        $this->assertEquals($EmailCredential->user_id, $user_id);
        $this->assertEquals($EmailCredential->username, $username);
        $this->assertEquals($EmailCredential->password, $password);
        $this->assertEquals($EmailCredential->smtp_host, $smtp_host);
        $this->assertEquals($EmailCredential->smtp_port, $smtp_port);

        // See if credentials were saved in DB
        $EmailCredential2 = new EmailCredential($id);
        $this->assertEquals($EmailCredential2->id, $id);
        $this->assertEquals($EmailCredential2->user_id, $user_id);
        $this->assertEquals($EmailCredential2->username, $username);
        $this->assertEquals($EmailCredential2->password, $password);
        $this->assertEquals($EmailCredential2->smtp_host, $smtp_host);
        $this->assertEquals($EmailCredential2->smtp_port, $smtp_port);
    }

    /**
     * Tests the update function.
     */
    public function testUpdate()
    {
        // Info for email credentials to be updated
        $user_id = $this->User->id;
        $username = 'user'.rand();
        $password = 'my'.rand();
        $smtp_host = rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255);
        $smtp_port = rand(1, 1000);
        $EmailCredential = new EmailCredential();
        $id = $EmailCredential->create($user_id, $username, $password, $smtp_host, $smtp_port);

        // Update credentials
        $username2 = 'user'.rand();
        $password2 = 'my'.rand();
        $smtp_host2 = rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255);
        $smtp_port2 = rand(1, 1000);
        $success = $EmailCredential->update($username2, $password2, $smtp_host2, $smtp_port2);
        $this->assertTrue($success);
        $this->assertEquals($EmailCredential->user_id, $user_id);
        $this->assertEquals($EmailCredential->username, $username2);
        $this->assertEquals($EmailCredential->password, $password2);
        $this->assertEquals($EmailCredential->smtp_host, $smtp_host2);
        $this->assertEquals($EmailCredential->smtp_port, $smtp_port2);

        // test with old (now "deleted") id
        $EmailCredential3 = new EmailCredential($id);
        $this->assertFalse(isset($EmailCredential3->id));
    }

    /**
     * Tests the delete function.
     */
    public function testDelete()
    {
        // Info for email credentials to be deleted
        $user_id = $this->User->id;
        $username = 'user'.rand();
        $password = 'my'.rand();
        $smtp_host = rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255);
        $smtp_port = rand(1, 1000);
        $EmailCredential = new EmailCredential();
        $id = $EmailCredential->create($user_id, $username, $password, $smtp_host, $smtp_port);

        // Delete it!
        $EmailCredential->delete();
        $this->assertFalse(isset($EmailCredential->id));
        $this->assertFalse(isset($EmailCredential->user_id));
        $this->assertFalse(isset($EmailCredential->username));
        $this->assertFalse(isset($EmailCredential->password));
        $this->assertFalse(isset($EmailCredential->smtp_host));
        $this->assertFalse(isset($EmailCredential->smtp_port));
    }
}
