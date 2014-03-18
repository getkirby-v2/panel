<?php 

return array(

  'show' => function() use($site) {

    $page = get('uri') ? $site->find(get('uri')) : $site;    
    $file = $page->files()->find(get('filename'));

    if(!$file) {
      echo response::error('No such file');
    } else {
      echo response::json(fileResponse($file));
    }

  },

  'upload' => function() use($site) {

    $page = get('uri') ? $site->find(get('uri')) : $site;    
   
    $upload = new Upload;
    $upload->to($page->root() . DS . '{safeFilename}');
    $upload->success(function($file) {      
      echo response::success('The file has been uploaded');
    });      
    $upload->error(function($exception) {
      echo response::error($exception->getMessage());
    });

  },

  'delete' => function() use($site) {

    $page = get('uri') ? $site->find(get('uri')) : $site;    
    $file = $page->files()->find(get('filename'));

    if(!$file) {
      echo response::error('No such file');
    } else if(!f::remove($file->root())) {
      echo response::error('The file could not be removed');
    } else {
      echo response::success('The file has been removed');
    }
   
  }


);