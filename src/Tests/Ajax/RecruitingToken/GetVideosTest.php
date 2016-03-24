<?php
namespace Sizzle\Tests\Ajax\RecruitingToken;

use \Sizzle\Database\{
    RecruitingCompany,
    RecruitingCompanyVideo,
    RecruitingToken
};

/**
 * This class tests the ajax endpoint to get the videos for a token.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/RecruitingToken/GetVideosTest
 */
class GetVideosTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\User;

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testRequest()
    {
        // setup test user
        $this->User = $this->createUser();

        // setup test company
        $RecruitingCompany = new RecruitingCompany();
        $RecruitingCompany->user_id = $this->User->id;
        $RecruitingCompany->name = 'The '.rand().' Company';
        $RecruitingCompany->save();
        $this->RecruitingCompany = $RecruitingCompany;

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->User->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->recruiting_company_id = $RecruitingCompany->id;
        $RecruitingToken->save();
        $this->RecruitingToken = $RecruitingToken;

        // setup test images
        $RecruitingCompanyVideo = new RecruitingCompanyVideo();
        $source = 'vimeo';
        $source_id[1] = rand();
        $source_id[2] = rand();
        $source_id[3] = rand();
        $id[1] = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id[1]);
        $id[2] = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id[2]);
        $id[3] = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id[3]);

        // test for created images
        $url = TEST_URL . "/ajax/recruiting_token/get_videos/{$RecruitingToken->long_id}";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        //print_r($return);
        foreach ($return->data as $image) {
            $this->assertTrue(in_array($image->id, $id));
            $this->assertTrue(in_array($image->source_id, $source_id));
        }
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/recruiting_token/get_videos";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('', $return->data);
        ob_end_clean();
    }

    /**
     * Delete users created for testing
     */
    protected function tearDown()
    {
        //$this->deleteUsers();
    }
}
?>
