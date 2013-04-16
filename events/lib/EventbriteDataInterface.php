<?php


interface EventbriteDataInterface extends SearchDataRetriever {

  public function getOrganizerListEvents();
  public function getEvent($id);

}