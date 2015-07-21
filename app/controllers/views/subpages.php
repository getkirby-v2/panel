<?php

class SubpagesController extends Controller {

  public function index($id) {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);

    // don't create the view if the page is not allowed to have subpages
    if($blueprint->pages()->max() === 0) {
      throw new Exception('This page is not allowed to have subpages');
    }

    // get the subpages
    $visible   = $this->visible($page, $blueprint);
    $invisible = $this->invisible($page, $blueprint);

    // activate the sorting
    $this->sort($page);

    return screen('subpages/index', $page, array(
        'page'                => $page,
        'addbutton'           => addbutton($page),
        'sortable'            => $blueprint->pages()->sortable(),
        'flip'                => $blueprint->pages()->sort() == 'flip',
        'visible'             => $visible,
        'invisible'           => $invisible,
    ));

  }

  protected function subpages($page, $blueprint, $type) {

    $pages = api::subpages($page->children()->$type(), $blueprint);    

    if($limit = $blueprint->pages()->limit()) {

      // create a session id to store the page
      $sessionId = 'subpages.' . $type . '.' . $page->cacheId();

      // add pagination 
      $pages = $pages->paginate($limit, array(
        'page'          => get($type, s::get($sessionId)), 
        'omitFirstPage' => false, 
        'variable'      => $type,
        'method'        => 'query'
      ));

      // store the last page
      s::set($sessionId, $pages->pagination()->page());
      
      $pagination = new Snippet('subpages/pagination', array(
        'pagination' => $pages->pagination(),
        'nextUrl'    => $pages->pagination()->nextPageUrl(),
        'prevUrl'    => $pages->pagination()->prevPageUrl(),
      ));
    }

    return new obj(array(
      'pages'      => $pages, 
      'pagination' => $pagination,
      'start'      => $pages->pagination()->numStart(),
      'total'      => $pages->pagination()->items(),       
      'firstPage'  => $pages->pagination()->firstPageUrl(),
    ));

  }

  protected function visible($page, $blueprint) {
    return $this->subpages($page, $blueprint, 'visible');
  }

  protected function invisible($page, $blueprint) {
    return $this->subpages($page, $blueprint, 'invisible');
  }

  protected function sort($page) {

    // handle sorting
    if(r::is('post') and $action = get('action') and $id = get('id')) {

      $subpages = new Subpages($page);
      $subpage  = $subpages->find($id);

      switch($action) {
        case 'sort':
          try {
            $subpages->sort($subpage, get('to'));
          } catch(Exception $e) {
            // no error handling, because if sorting 
            // breaks, the refresh will fix it.
          }
          break;
        case 'hide':
          try {
            $subpages->hide($subpage);
          } catch(Exception $e) {
            // no error handling, because if sorting 
            // breaks, the refresh will fix it.
          }
          break;
      }

      $this->redirect($page, 'subpages');

    }

  }


  protected function page($id) {

    $page = $id == '/' ? site() : page($id);

    if(!$page) {
      throw new Exception(l('subpages.error.missing'));
    } else {
      return $page;      
    }

  }

}