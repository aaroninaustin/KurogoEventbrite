<?php

class EventbriteEvent extends KurogoDataObject {

  protected $owner;

  public function getTicketsLeft(){
    return sprintf("Tickets Left: %s / %s", $this->getAttribute('ticket_quantity_sold'), $this->getAttribute('ticket_quantity_available'));
  }

  public function getStartDate(){
	$date = strtotime($this->getAttribute('start_date'));
  	$betterdate = date('F jS g:i:s A', $date);
  	return sprintf("%s", $betterdate);
  }

}
