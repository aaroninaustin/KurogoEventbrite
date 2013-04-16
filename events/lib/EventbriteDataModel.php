<?php

class EventbriteDataModel extends DataModel{

  protected $DEFAULT_RETRIEVER_CLASS = 'EventbriteDataRetriever';
  protected $RETRIEVER_INTERFACE = 'EventbriteDataInterface';

  public function setLimit($limit) {
    $this->setOption('limit', $limit);
  }
}