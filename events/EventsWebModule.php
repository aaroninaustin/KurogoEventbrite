<?php


Kurogo::includePackage('DateTime');

class EventsWebModule extends WebModule{

  protected $id = 'events';
  protected $model;
  protected $detailsController;

  protected function initialize(){
    $this->detailsController = new DataObjectDetailsController($this);

    $feedData = $this->loadFeedData();
    $feed = current($feedData);
    $this->model = DataModel::factory('EventbriteDataModel', $feed);
	}

  protected function linkForEvent(EventbriteEvent $event){
    $link = array(
      'title'    => $event->getTitle(),
      'subtitle' => $event->getStartDate(),
      'url'      => $this->buildBreadcrumbURL('event', array('id' => $event->getID())),
    );
    return $link;
  }

 protected function buildEventsList($items){
    $links = array();
    foreach ($items as $item) {
      $links[] = $this->linkForEvent($item);
    }
    return $links;
  }


  protected function initializeForPage(){
    switch ($this->page) {
      
      case 'index':
        $eventItems = $this->model->getOrganizerListEvents();
        $events = $this->buildEventsList($eventItems);
        $this->assign('recentEvents', array_reverse($events));
        $this->assign('placeholder', $this->getOptionalModuleVar("SEARCH_PLACEHOLDER"));
        $this->assign('upcomingEventsHeader ', $this->getOptionalModuleVar("UPCOMING_EVENTS_HEADER"));
        break;
      case 'event':
        if(!$id = $this->getArg('id')){
          $this->redirectTo('index');
        }

        $event = $this->model->getEvent($id);
        $this->assign('eventTitle', $event->getTitle());
        $this->assign('start_date', $event->getStartDate());
        $this->assign('body', $event->getAttribute('body'));
        $this->assign('url', $event->getAttribute('url'));
        break;  
      case 'search':
       if(!$searchTerms = trim($this->getArg('filter'))){
          $this->redirectTo('index');
        }

        $this->model->setLimit(20);
        
        $resultItems = $this->model->search($searchTerms);
        
        $summary = array_pop($resultItems);

        $results = $this->buildEventsList($resultItems);

        $total_items = $summary->total_items;

        $this->assign('total_items', $total_items);

        $this->assign('keywords', $searchTerms);

        $this->assign('results', $results);
        break;


    }
  }



}