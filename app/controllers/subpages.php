<?php

class SubpagesController extends Kirby\Panel\Controllers\Base {

  public function index($id) {

    $page = $this->page($id);
    $user = panel()->user();

    // don't create the view if the page is not allowed to have subpages
    if(!$page->canHaveSubpages()) {
      throw new Exception('This page is not allowed to have subpages');
    }

    // get the subpages
    $visible   = $this->visible($page);
    $invisible = $this->invisible($page);

    // activate the sorting
    $this->sort($page);

    return $this->screen('subpages/index', $page, array(
      'page'         => $page,
      'addbutton'    => $user->isAllowed('createSubpages', $page) ? $page->addbutton(): false,
      'sortable'     => $user->isAllowed('sortSubpages', $page) and $page->blueprint()->pages()->sortable(),
      'flip'         => $page->blueprint()->pages()->sort() == 'flip',
      'visible'      => $visible,
      'invisible'    => $invisible,
      'visibleBtn'   => $this->pagePermissions($visible),
      'invisibleBtn' => $this->pagePermissions($invisible),
    ));

  }

  protected function subpages($page, $type) {

    $pages = $page->children()->$type();

    if($limit = $page->blueprint()->pages()->limit()) {

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

      $pagination = $this->snippet('subpages/pagination', array(
        'pagination' => $pages->pagination(),
        'nextUrl'    => $pages->pagination()->nextPageUrl(),
        'prevUrl'    => $pages->pagination()->prevPageUrl(),
      ));
    }

    return new Obj(array(
      'pages'      => $pages,
      'pagination' => $pagination,
      'start'      => $pages->pagination()->numStart(),
      'total'      => $pages->pagination()->items(),
      'firstPage'  => $pages->pagination()->firstPageUrl(),
    ));

  }

  protected function visible($page) {
    return $this->subpages($page, 'visible');
  }

  protected function invisible($page) {
    return $this->subpages($page, 'invisible');
  }

  protected function pagePermissions($subpages){
    $return = array();
    foreach($subpages->pages() as $key => $subpage) {
      $return[$key] = array(
        'canEdit'   => panel()->user()->isAllowed('editPage', $subpage),
        'canDelete' => panel()->user()->isAllowed('deletePage', $subpage),
      );
    }
    return $return;
  }

  protected function sort($page) {

    // handle sorting
    if(r::is('post') and $action = get('action') and $id = get('id')) {

      $subpage = $this->page($page->id() . '/' . $id);

      switch($action) {
        case 'sort':
          try {
            $subpage->sort(get('to'));
          } catch(Exception $e) {
            // no error handling, because if sorting
            // breaks, the refresh will fix it.
          }
          break;
        case 'hide':
          try {
            $subpage->hide();
          } catch(Exception $e) {
            // no error handling, because if sorting
            // breaks, the refresh will fix it.
          }
          break;
      }

      $this->redirect($page, 'subpages');

    }

  }

}
