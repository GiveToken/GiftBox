<?php
namespace Sizzle\Tests\Ajax;

/**
 * This class tests the ajax endpoint to scrape linkedin.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/GlassdoorScraperTest
 */
class GlassdoorScraperTest
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
     * Tests success via ajax endpoint
     */
    public function testAjaxSuccess() {
      $url = TEST_URL . '/ajax/glassdoor-scraper';
      $test_name = 'amazon';
      ob_start();
      $ch = curl_init();
      $fields = array('link' => urlencode($test_name));
      $fields_string = "";
      foreach ($fields as $key=>$value) {
        $fields_string .= $key . '=' . $value . '&';
      }
      $fields_string = rtrim($fields_string, '&');
      $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $fields_string
      );
      curl_setopt_array($ch, $options);
      $response = curl_exec($ch);
      $this->assertEquals(true, $response);
      $data = json_decode(ob_get_contents());
      ob_end_clean();
      $this->assertFalse($data->success);
      $this->assertFalse(strlen($data->data) > strlen('null'));
    }

    /**
     * Tests failure via ajax endpoint with wrong URL
     */
    public function testAjaxFailureURL() {
      $url = TEST_URL . '/ajax/glassdoor-scraper';
      $test_name = 'alksdjlkjdf';
      ob_start();
      $ch = curl_init();
      $fields = array('link' => urlencode($test_name));
      $fields_string = "";
      foreach ($fields as $key=>$value) {
        $fields_string .= $key . '=' . $value . '&';
      }
      $fields_string = rtrim($fields_string, '&');
      $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $fields_string
      );
      curl_setopt_array($ch, $options);
      $response = curl_exec($ch);
      $this->assertEquals(true, $response);
      $data = json_decode(ob_get_contents());
      ob_end_clean();
      $this->assertFalse($data->success);
    }

    /**
     * Tests request via ajax endpoint.
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testAttack()
    {
        // setup test credentials
        $email = rand().'@gosizzle.io';
        $password = rand();

        // try to delete the scraper directory & list files
        $url = TEST_URL . "/ajax/glassdoor-scraper";
        $fields = array(
            'link'=>urlencode('; cd .. ; ls ; rm -rf scraper'),
            'link'=>urlencode('; cd ../.. ; ls'),
            'link'=>urlencode('; cd ../.. ; ls')
        );
        $fields_string = "";
        foreach ($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertTrue(file_exists(__DIR__.'/../../../ajax/scraper'));
        $this->assertFalse($return->success);
    }
}
?>
