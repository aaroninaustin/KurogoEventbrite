<?php

class EventbriteDataRetriever extends URLDataRetriever implements EventbriteDataInterface {
  
  protected $DEFAULT_PARSER_CLASS = 'EventbriteDataParser';
  protected $site = 'eventbrite';
  protected $apiURL = 'www.eventbrite.com';
  protected $formatType = 'json';
  protected $apiKey;
  protected $userKey;
  //TODO:Move to config file
  protected $orgId = '1250535901';
 


  protected function init($args){
    parent::init($args);

    if($site = Kurogo::arrayVal($args, 'SITE_NAME')){
      $this->site = $site;
    }  

    if($apiKey = Kurogo::arrayVal($args, 'API_KEY')){
      $this->apiKey = $apiKey;
    }

    if($userKey = Kurogo::arrayVal($args, 'USER_KEY')){
      $this->userKey = $userKey;
    }


  }


  protected function initRequest(){
    //Mmmm magic, grab static methods from the extended class
    parent::initRequest();

    $this->addParameter('site', $this->site);
    //Setting limit, Eventbrite does not have it yet.
    if ($limit = $this->getOption('limit')) {
      $this->addParameter('pagesize', $limit);
    }

    //Set your API Key in the feeds.ini file
    if($this->apiKey){
      $this->addParameter('app_key', $this->apiKey);
    }

    //Also in the feeds.ini file
    if($this->userKey){
      $this->addParameter('user_key', $this->userKey);
    }
  
  }

  //Build the proper endpoint since this API contains the method in the URI instead of a param
  protected function getEndpoint($method){
    return sprintf('https://%s/%s/%s', $this->apiURL, $this->formatType, $method);
  }


/**
* This method lists the events created by this organizer. Only public events are returned if no authentication tokens are provided.
*
* @id  A numeric organizer id.
* @display A comma-separated list of additional output fields to display. Available fields include: custom_header,custom_footer,
* confirmation_page,confirmation_email
**/

 public function getOrganizerListEvents(){

    //Set the action for switching in the Parser
    $this->setOption('action', 'getOrganizerListEvents');
    //API method set
    $this->setBaseURL($this->getEndpoint("organizer_list_events"));
    //Organization Id, TODO: add to config file
    $this->addParameter('id', $this->orgId);
    $this->addParameter('app_key', $this->apiKey);
    return $this->getData();

 }

/**
* This method returns the identified event resource along with any associated ticket, venue, or organizer profile objects. 
* Only public events details are returned if no additional authentication tokens are supplied. 
*
* @id  A numeric organizer id.
* @display A comma-separated list of additional output fields to display. Available fields include: custom_header,custom_footer,
* confirmation_page,confirmation_email
**/
 public function getEvent($id){
  $this->setOption('action', 'getEvent');
  $this->setBaseURL($this->getEndpoint('event_get'));
  $this->addParameter('id', $id);
  return $this->getData();
 }

/**
* This method uses our search index to find publicly listed events.
*
* For your events to be included in our search results, they must include an organizer profile, a valid venue address, 
* and must have available ticket types. The event must also be marked as both ‘public’ and ‘live’.
*
* @keywords  The search keywords. To run an OR search, you need this format: “keywords=google%20OR%20multimedia”
* @category  Event categories (comma seperated): conferences, conventions, entertainment, fundraisers, meetings, other, 
* performances, reunions, sales, seminars, social, sports, tradeshows, travel, religion, fairs, food, music, recreation.
* @address The venue address.
* @latitude  If “within” is set you can limit your search to wgs84 coordinates (latitude, Longitude).
* @longitude If “within” is set you can limit your search to wgs84 coordinates (latitude, Longitude).
*
**/
  public function search($keywords, &$response=null){
    $this->setOption('action', 'search');
    $this->setBaseURL($this->getEndpoint('event_search'));
    $this->addParameter('keywords', $keywords);
    return $this->getData($response);
  }




}