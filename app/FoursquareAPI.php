<?php

namespace App;
use Jcroll\FoursquareApiClient\Client\FoursquareClient;

/**
 * Distance values are defined in meters.
 */
define('COORDINATES_ACCURACY', 1000);
define('RESULTS_CATEGORY','food');
define('YES', 1);
define('SEARCH_RADIUS', 7000);
define('DEFAULT_PAGINATION_OFFSET', 20);
define('RESULTS_NUMBER', 15);
define('COMMAND_TYPE', 'venues/explore');

class FoursquareAPI{

    private $client;

    public function __construct(){

        $clientToken = array(
            'client_id'     => 'DA1CVJNBDE2O4KP11O1Z01ACSUICGAT1QY4KZFIC40MT25QI',
            'client_secret' => 'WAQT0FHFMDIJ15Q01EPQNMUV02CWUFWGT2F2AVYOQTQZBLVZ'
        );

        $this->client = FoursquareClient::factory($clientToken);
    }

    public function find($id){

        //TODO: Implement this badboy
    }

    public function all($latitude, $longitude){

        $template = '%f,%f';
        $ll = sprintf($template, $latitude, $longitude);

        $constraints = array(
            'llAcc' => COORDINATES_ACCURACY,
            'll' => $ll,
            'venuePhotos' => YES,
            'section' => RESULTS_CATEGORY,
            'sortByDistance' => YES,
            'limit' => RESULTS_NUMBER,
            'radius' => SEARCH_RADIUS,
            'openNow' => YES,
            'offset' => DEFAULT_PAGINATION_OFFSET,
        );

        $command = $this->client->getCommand(COMMAND_TYPE, $constraints);
        $result = $command->execute();

        if($result['meta']['code'] == 200){
            return $this->getVenues($result);
        }

        return [];
    }

    private function getVenues($explorationResult){
        $venues = array();
        $groups = $explorationResult['response']['groups'];
        foreach($groups as $group){
            $items = $group['items'];
            foreach($items as $item){
                $venues[] = $item['venue'];
            }
        }
        return $venues;
    }
}