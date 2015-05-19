<?php

class FilesController extends Controller {

  public function index($id = null) {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);
    $files     = api::files($page, $blueprint);
    $back      = purl($page, 'show');

    // don't create the view if the page is not allowed to have files
    if($blueprint->files()->max() === 0) goToErrorView();


    if($page->isSite()) {

      // breadcrumb items
      $items = array(
        array(
          'url'   => purl('metatags'),
          'title' => l('metatags')
        ),
        array(
          'url'   => purl('files/index'),
          'title' => l('metatags.files')
        )
      );      

      // modify the back url
      $back = purl('metatags');

    } else {
      // breadcrumb items
      $items = array(
        array(
          'url'   => purl('files/index/' . $page->id()),
          'title' => l('files')
        )
      );      
    }

    return view('files/index', array(
      'topbar' => new Snippet('pages/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('pages/breadcrumb', array(
          'page'  => $page,
          'items' => $items
        )),
        'search' => purl($page, 'search')
      )),
      'page'     => $page,
      'files'    => $files,
      'back'     => $back,
      'sortable' => $blueprint->files()->sortable(),
    ));

  }

  public function upload($id = null) {

    $page = $this->page($id);
    $back = array(
      'files'    => purl('files/index/' . $page->id()),
      'metatags' => purl('metatags'),
      'page'     => purl($page, 'show')
    );

    return view('files/upload', array(
      'p'    => $page,
      'back' => a::get($back, get('to'))
    ));
  }

  public function show($id = null) {

    $filename  = get('filename');
    $page      = $this->page($id);
    $file      = $this->file($page, $filename);
    $blueprint = blueprint::find($page);
    $fields    = $blueprint->files()->fields($page);
    $meta      = $file->meta()->toArray();
    $files     = api::files($page, $blueprint);
    $index     = $files->indexOf($file);
    $next      = $files->nth($index + 1);
    $prev      = $files->nth($index - 1);

    // breadcrumb items
    if($page->isSite()) {
      $items = array(
        array(
          'url'   => purl('metatags'),
          'title' => l('metatags')
        ),
        array(
          'url'   => purl('files/index'),
          'title' => l('metatags.files')
        ),
        array(
          'url'   => purl($file, 'show'),
          'title' => $file->filename()
        ),
      );      
    } else {
      $items = array(
        array(
          'url'   => purl('files/index/' . $page->id()),
          'title' => l('files')
        ),
        array(
          'url'   => purl($file, 'show'),
          'title' => $file->filename()
        ),
      );      
    }

    // file info display
    $info = array();

    $info[] = $file->type();
    $info[] = $file->niceSize();

    if((string)$file->dimensions() != '0 x 0') {
      $info[] = $file->dimensions();      
    }

    return view('files/show', array(
      'topbar' => new Snippet('pages/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('pages/breadcrumb', array(
          'page'  => $page,
          'items' => $items,
        )),
        'search' => purl($page, 'search')
      )),
      'form' => new Form($fields->toArray(), $meta),
      'p'    => $page,
      'f'    => $file,
      'next' => $next,
      'prev' => $prev,
      'info' => implode(' / ', $info)
    ));

  }

  public function replace($id = null) {

    $filename = get('filename');
    $page     = $this->page($id);
    $file     = $this->file($page, $filename);

    return view('files/replace', array(
      'p' => $page,
      'f' => $file
    ));

  }

  public function delete($id = null) {

    $filename = get('filename');
    $page     = $this->page($id);
    $file     = $this->file($page, $filename);
    $back     = array(
      'index' => purl('files/index/' . $page->id()),
      'file'  => purl($file, 'show')
    );

    return view('files/delete', array(
      'p'    => $page,
      'f'    => $file,
      'back' => a::get($back, get('to'))
    ));

  }

  protected function page($id) {

    if(!$id) {
      return site();
    } else if($page = page($id)) {
      return $page;
    } else {
      throw new Exception(l('files.error.missing.page'));
    }

  }

  protected function file($page, $filename) {

    if($file = $page->file($filename)) {
      return $file;
    } else {
      throw new Exception(l('files.error.missing.file'));
    }

  }

}