<?php
namespace Sizzle\Tests;

use \Devio\Pipedrive\Http\Response;
/**
 * This class tests the Pipedrive class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Service/PipedriveTest
 */
class PipedriveTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Cleans up after the tests
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        $PipedriveClient = new \Sizzle\Service\PipedriveClient(PIPEDRIVE_API_TOKEN);
        $this->assertEquals('Sizzle\Service\PipedriveClient', get_class($PipedriveClient));
    }

    /**
     * Tests the API Key successfully authorizes requests
     */
    public function testAPIKeySuccessfullyAuthorizes()
    {
        $PipedriveClient = new \Sizzle\Service\PipedriveClient(PIPEDRIVE_API_TOKEN);
        $this->assertTrue($PipedriveClient->isAuthorized());
    }

    /**
     * Tests that fake API Key fails authorizing requests
     */
    public function testFakeAPIKeyFailsAuthorization()
    {
        $PipedriveClient = new \Sizzle\Service\PipedriveClient('FakeToken');
        $this->assertFalse($PipedriveClient->isAuthorized());
    }

    /**
     * Verify that if a newly signed-up person exists in Pipedrive and there
     * is a deal associated with them already, then the associated organization
     * is in a free trial state.
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testCreateFreeTrialWithExistingDealAndExistingPerson()
    {
        $freeTrialEmailAddress = 'fakeemail@sizzle.io';
        $personId = 1;
        $organizationId = 2;

        // Mock out Pipedrive API Client
        $mockedPipedrive = \Mockery::mock('overload:\\Devio\Pipedrive\Pipedrive')->makePartial();
        $this->assertTrue($mockedPipedrive  instanceof \Mockery\MockInterface);

        $examplePipedrivePersonsFindByNameBodyResponse = "{
            \"success\": true,
            \"data\": [
                {
                    \"id\": ".$personId.",
                    \"email\": \"".$freeTrialEmailAddress."\",
                    \"org_id\": ".$organizationId."
                }
            ],
            \"additional_data\": {
                \"search_method\": \"search_by_email\",
                \"pagination\": {
                    \"start\": 0,
                    \"limit\": 100,
                    \"more_items_in_collection\": false
                }
            }
        }";

        $examplePipedrivePersonsDealsBodyResponse = "{
            \"success\": true,
            \"data\": [
                {
                    \"person_id\": {
                        \"email\": [
                            {
                                \"value\": \"".$freeTrialEmailAddress."\",
                                \"primary\": true
                            }
                        ]
                    },
                    \"org_id\": {
                        \"value\": ".$organizationId."
                    }
                }
            ]
        }";

        $examplePipedriveUpdateOrganizationBodyResponse = "{
            \"success\": true,
            \"data\": [
                {
                    \"id\": ".$organizationId.",
                    \"6a06247b91272ae63df08657bd3fe5e716a7f519\": \"Free Trial\"
                }
            ],
            \"additional_data\": {
                \"pagination\": {
                    \"start\": 0,
                    \"limit\": 1,
                    \"more_items_in_collection\": true,
                    \"next_start\": 1
                }
            }
        }";
        // The Persons API should be called to check if a Person exists in Pipedrive
        // In this test, the Person exists
        $mockedPipedrive->shouldReceive('persons->findByName')->ordered()->once()
            ->with($freeTrialEmailAddress, ["search_by_email" => true])
            ->andReturn(new Response(200, json_decode($examplePipedrivePersonsFindByNameBodyResponse)));

        // Then, the Persons API should be called to check if a Deal is associated with the Person
        // In this test, the Deal exists
        $mockedPipedrive->shouldReceive('persons->deals')->ordered()->once()
            ->with($personId)
            ->andReturn(new Response(200, json_decode($examplePipedrivePersonsDealsBodyResponse)));

        // Finally, the Organizations API should be called to update the associated Organization's
        // status to "Free Trial"
        $mockedPipedrive
            ->shouldReceive('organizations->update')->ordered()->once()
            ->with($organizationId, array("6a06247b91272ae63df08657bd3fe5e716a7f519" => "FreeTrial"))
            ->andReturn(new Response(200, json_decode($examplePipedriveUpdateOrganizationBodyResponse)));


        $PipedriveClient = new \Sizzle\Service\PipedriveClient(PIPEDRIVE_API_TOKEN);
        $signupPayload = ["email_address" => $freeTrialEmailAddress, "first_name" => "Fake", "last_name" => "Person"];

        $this->assertTrue($PipedriveClient->createFreeTrial($signupPayload));
    }

    /**
     * Verify t...
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testCreateFreeTrialWithNoExistingDealAndExistingPerson()
    {
        // TODO
        $this->markTestIncomplete();
    }

    /**
     * Verify t...
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testCreateFreeTrialWithExistingDealAndNoExistingPerson()
    {
        // TODO
        $this->markTestIncomplete();
    }

    /**
     * Verify t...
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testCreateFreeTrialWithNoExistingDealAndNoExistingPerson()
    {
        // TODO
        $this->markTestIncomplete();
    }
}
