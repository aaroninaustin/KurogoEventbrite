<?php

class EventbriteDataParser extends JSONDataParser {
  
  public function parseData($data){


   //Not using the parent method, because assoc array was weird with eventbrites data structure.
   $data = json_decode($data);
  
       $action = $this->getOption('action');
	    switch ($action) {
	      case 'search':	
	       $events = array();
	       $length = sizeof($data->events);
	      	 
	       for ($i=1; $i < $length; $i++) {
	       	
	       	if($data->events[$i]->event->status != 'Completed' AND $data->events[$i]->event->status != 'Unsaved') {
	       		$events[] = $this->parseEvent($data->events[$i]->event); 
	       	}	
	       }
	       //Lets hide the summary data here and pop it off for the view.
	       $summary = $data->events[0]->summary;
	       array_push($events, $summary);
	        return $events;
	        break;
	      break;

	      case 'getOrganizerListEvents': 
	       $events = array();
	       $length = sizeof($data->events);
	       
	       for ($i=0; $i < $length; $i++) {
	       	
	       	if($data->events[$i]->event->status != 'Completed' AND $data->events[$i]->event->status != 'Unsaved') {
	       		$events[] = $this->parseEvent($data->events[$i]->event); 
	       	}	
	       }
	        return $events;
	        break;

	        case 'getEvent':
	        	$event = $this->parseEvent($data->event);
	        return $event;	
	        break;


	    }
	}

    protected function parseEvent($data){

	    $event = new EventbriteEvent();
	    $event->setID($data->id);
	    $event->setTitle($data->title);
	  	$event->setAttribute('body', $data->description);
	    $event->setAttribute('start_date', $data->start_date);
	    $event->setAttribute('end_date', $data->end_date);
	    $event->setAttribute('timezone', $data->timezone);
	    $event->setAttribute('url', $data->url);
	    $event->setAttribute('created', $data->created);
	    $event->setAttribute('modified', $data->modified);
	    $event->setAttribute('privacy', $data->privacy);
	    $event->setAttribute('start_date', $data->start_date);
	    $event->setAttribute('status', $data->status);
	    if (isset($data->venue)) {
		    $event->setAttribute('venue_id', $data->venue->id);
		    $event->setAttribute('venue_name', $data->venue->name);
		}
		
	    return $event;
  }


}