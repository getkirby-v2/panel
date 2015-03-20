<?php

class SubpagesController extends Controller {

  public function index($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);
    $blueprint    = blueprint::find($page);
    $visible      = api::subpages($page->children()->visible(), $blueprint);
    $invisible    = $page->children()->invisible();
    $baseUrl      = rtrim(purl('subpages/index/' . $page->id()), '/');

    // don't create the view if the page is not allowed to have subpages
    if($blueprint->pages()->max() === 0) {
      goToErrorView();
    }

    if($limit = $blueprint->pages()->limit()) {

      $visible   = $visible->paginate($limit, array('page' => get('visible')));
      $visibleBtns = array('edit' => array(), 'delete' => array());
      foreach ($visible as $index => $subpage) {
        $subpageOptions = new PageOptions($subpage);
        $visibleBtns['edit'][$subpage->uid()] = $subpageOptions->canEdit();
        $visibleBtns['delete'][$subpage->uid()] = $subpageOptions->canDelete();
      }
      $invisible = $invisible->paginate($limit, array('page' => get('invisible')));
      $invisibleBtns = array('edit' => array(), 'delete' => array());
      foreach ($invisible as $index => $subpage) {
        $subpageOptions = new PageOptions($subpage);
        $invisibleBtns['edit'][$subpage->uid()] = $subpageOptions->canEdit();
        $invisibleBtns['delete'][$subpage->uid()] = $subpageOptions->canDelete();
      }

      $visiblePagination = new Snippet('subpages/pagination', array(
        'pagination' => $visible->pagination(),
        'nextUrl'    => $baseUrl . '/visible:' . $visible->pagination()->nextPage() . '/invisible:' . $invisible->pagination()->page(),
        'prevUrl'    => $baseUrl . '/visible:' . $visible->pagination()->prevPage() . '/invisible:' . $invisible->pagination()->page(),
      ));

      $invisiblePagination = new Snippet('subpages/pagination', array(
        'pagination' => $invisible->pagination(),
        'nextUrl'    => $baseUrl . '/visible:' . $visible->pagination()->page() . '/invisible:' . $invisible->pagination()->nextPage(),
        'prevUrl'    => $baseUrl . '/visible:' . $visible->pagination()->page() . '/invisible:' . $invisible->pagination()->prevPage(),
      ));

    }

    return view('subpages/index', array(
      'page'   => $page,
      'topbar' => new Snippet('pages/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('pages/breadcrumb', array(
          'page'  => $page,
          'items' => array(
            array(
              'url'   => purl('subpages/index/' . $id),
              'title' => l('subpages')
            )
          )
        )),
        'search' => purl($page, 'search')
      )),
      'baseurl'             => $baseUrl,
      'addbutton'           => $pageOptions->canSubpagesAdd(),
      'sortable'            => $pageOptions->canSubpagesSort(),
      'visible'             => $visible,
      'visibleEditBtns'     => $visibleBtns['edit'],
      'visibleDeleteBtns'   => $visibleBtns['delete'],
      'flip'                => $blueprint->pages()->sort() == 'flip',
      'visiblePagination'   => $visiblePagination,
      'invisible'           => $invisible,
      'invisibleEditBtns'   => $invisibleBtns['edit'],
      'invisibleDeleteBtns' => $invisibleBtns['delete'],
      'invisiblePagination' => $invisiblePagination,
    ));

  }

  protected function page($id) {

    $page = !$id ? site() : page($id);

    if(!$page) throw new Exception(l('subpages.error.missing'));

    return $page;

  }

}
