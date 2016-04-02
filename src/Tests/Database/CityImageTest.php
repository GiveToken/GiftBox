<?php
namespace Sizzle\Tests;

use Sizzle\Database\City;
use Sizzle\Database\CityImage;

/**
 * This class tests the City class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/tests/Database/CityImageTest
 */
class CityImageTest extends \PHPUnit_Framework_TestCase
{
    protected $city_with_images;
    protected $city_with_no_images;

    /**
   * Requires the util.php file of functions
   */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    private function generateCity()
    {
        // create a city for testing
        $city = new City();
        $city->name = "Test City".rand();;
        $city->image_file = "city.png";
        $city->population = rand(10000, 10000000);
        $city->longitude = rand(0, 100);
        $city->latitude = rand(0, 100);
        $city->county = "County " . rand(0, 100);
        $city->country = "CT";
        $city->timezone = "Awesome Standard Time";
        $city->temp_hi_spring = rand(0, 100);
        $city->temp_lo_spring = rand(0, 100);
        $city->temp_avg_spring = rand(0, 100);
        $city->temp_hi_summer = rand(0, 100);
        $city->temp_lo_summer = rand(0, 100);
        $city->temp_avg_summer = rand(0, 100);
        $city->temp_hi_fall = rand(0, 100);
        $city->temp_lo_fall = rand(0, 100);
        $city->temp_avg_fall = rand(0, 100);
        $city->temp_hi_winter = rand(0, 100);
        $city->temp_lo_winter = rand(0, 100);
        $city->temp_avg_winter = rand(0, 100);
        return $city;
    }

    protected function setUp()
    {
        // city with images
        $this->city_with_images = $this->generateCity();
        $this->city_with_images->save();
        $city_id = $this->city_with_images->id;
        $sql = "INSERT INTO `giftbox`.`city_image` (`city_id`, `image_file`) VALUES ('$city_id', 'AL/Ralph/3.svg');";
        insert($sql); // image #1
        insert($sql); // image #2
        insert($sql); // image #3
        insert($sql); // image #4

        // city with no images
        $this->city_with_no_images = $this->generateCity();
        $this->city_with_no_images->save();
    }

    public function testGetAllImagesForCity()
    {
        $imagesForCityWithImages = CityImage::getAllImageUrlsForCity($this->city_with_images->id);
        $this->assertEquals(4, count($imagesForCityWithImages));

        $imagesForCityWithNoImages = CityImage::getAllImageUrlsForCity($this->city_with_no_images->id);
        $this->assertEquals(0, count($imagesForCityWithNoImages));
    }
}
