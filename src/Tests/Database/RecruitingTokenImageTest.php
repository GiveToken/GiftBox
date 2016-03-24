<?php
namespace Sizzle\Tests\Database;

use \Sizzle\Database\{
    RecruitingToken,
    RecruitingTokenImage
};

/**
 * This class tests the RecruitingTokenImage class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Database/RecruitingTokenImageTest
 */
class RecruitingTokenImageTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\User;

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // no params
        $result = new RecruitingTokenImage();
        $this->assertEquals('Sizzle\Database\RecruitingTokenImage', get_class($result));

        // test with bad id
        $result2 = new RecruitingTokenImage(-1);
        $this->assertFalse(isset($result2->id));

        // test with good id in testCreate() below
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        $User = $this->createUser();
        $token = new RecruitingToken();
        $token->user_id = $User->id;
        $token->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $token->save();

        // Create image
        $image = new RecruitingTokenImage();
        $fileName = rand().'.jpg';
        $id = $image->create($fileName, $token->id);

        // Check class variables set
        $this->assertEquals($image->id, $id);
        $this->assertEquals($image->file_name, $fileName);
        $this->assertEquals($image->recruiting_token_id, $token->id);

        // See if open was saved in DB
        $image2 = new RecruitingTokenImage($id);
        $this->assertEquals($image2->id, $id);
        $this->assertEquals($image2->file_name, $fileName);
        $this->assertEquals($image2->recruiting_token_id, $token->id);
    }

    /**
     * Tests the getByRecruitingTokenId function.
     */
    public function testGetByRecruitingTokenId()
    {
        $User = $this->createUser();
        $token = new RecruitingToken();
        $token->user_id = $User->id;
        $token->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $token->save();

        // Create images
        $image = new RecruitingTokenImage();
        $fileName = rand().'.jpg';
        $fileName2 = rand().'.png';
        $fileName3 = rand().'.gif';
        $id = $image->create($fileName, $token->id);
        $id = $image->create($fileName2, $token->id);
        $id = $image->create($fileName3, $token->id);

        // Test function
        $images = (new RecruitingTokenImage())->getByRecruitingTokenId($token->id);
        $this->assertEquals(3, count($images));
        $this->assertEquals($images[0]['file_name'], $fileName);
        $this->assertEquals($images[0]['recruiting_token_id'], $token->id);
        $this->assertEquals($images[1]['file_name'], $fileName2);
        $this->assertEquals($images[1]['recruiting_token_id'], $token->id);
        $this->assertEquals($images[2]['file_name'], $fileName3);
        $this->assertEquals($images[2]['recruiting_token_id'], $token->id);
    }

    /**
     * Delete users created for testing
     */
    protected function tearDown()
    {
        //$this->deleteUsers();
    }
}
