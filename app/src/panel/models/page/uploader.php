<?php 

namespace Kirby\Panel\Models\Page;

use Exception;
use Upload;

class Uploader {

  public $kirby;
  public $page;
  public $file;
  public $blueprint;
  public $filename;

  public function __construct($page, $file = null) {

    $this->page      = $page;
    $this->file      = $file;
    $this->blueprint = $page->blueprint();
    $this->filename  = $this->blueprint->files()->sanitize() ? '{safeFilename}' : '{filename}';

    if($this->file) {
      $this->replace();
    } else {
      $this->upload();      
    }

  }

  public function upload() {

    $upload = new Upload($this->page->root() . DS . $this->filename, array(
      'overwrite' => true,
      'accept'    => function($file) {

        $callback = kirby()->option('panel.upload.accept');

        if(is_callable($callback)) {
          return call($callback, $file);
        } else {
          return true;
        }

      }
    ));

    $file = $this->move($upload);

    kirby()->trigger('panel.file.upload', $file);          

  }

  public function replace() {

    $file   = $this->file;
    $upload = new Upload($file->root(), array(
      'overwrite' => true,
      'accept' => function($upload) use($file) {
        if($upload->mime() != $file->mime()) {
          throw new Error(l('files.replace.error.type'));
        }
      }
    ));

    $file = $this->move($upload);

    kirby()->trigger('panel.file.replace', $file);

  }

  public function move($upload) {

    // flush all cached files
    $this->page->reset();

    // get the file object from the upload
    $uploaded = $upload->file();

    // check if the upload worked
    if(!$uploaded) {
      throw new Exception($upload->error()->getMessage());
    }

    // check if the page has such a file
    $file = $this->page->file($uploaded->filename());

    // delete the upload if something went wrong
    if(!$file) {
      $uploaded->delete();
      throw new Exception('The file could not be found');
    }

    try {
      // security checks
      $this->checkUpload($file);
    } catch(Exception $e) {
      $file->delete();
      throw $e;
    }

  }

  public function checkUpload($file) {

    $filesettings        = $this->blueprint->files();
    $forbiddenExtensions = array('php', 'html', 'htm', 'exe', kirby()->option('content.file.extension', 'txt'));
    $forbiddenMimes      = array_merge(f::$mimes['php'], array('text/html', 'application/x-msdownload'));

    // block forbidden extensions
    if(in_array(strtolower($file->extension()), $forbiddenExtensions)) {
      throw new Exception('Forbidden file extension');
    }

    // especially block any connection that contains php
    if(str::contains(strtolower($file->extension()), 'php')) {
      throw new Exception('Forbidden file extension');
    }

    // block forbidden mimes
    if(in_array(strtolower($file->mime()), $forbiddenMimes)) {
      throw new Exception('Forbidden mime type');
    }
    
    // Block htaccess files
    if(strtolower($file->filename()) == '.htaccess') {
      throw new Exception('htaccess files cannot be uploaded');
    }

    // Block invisible files
    if(str::startsWith($file->filename(), '.')) {
      throw new Exception('Invisible files cannot be uploaded');
    }

    // Files blueprint option 'type'
    if(count($filesettings->type()) > 0 and !in_array($file->type(), $filesettings->type())) {
      throw new Exception('Page only allows: ' . implode(', ', $filesettings->type()));
    }

    // Files blueprint option 'size' 
    if($filesettings->size() and f::size($file->root()) > $filesettings->size()) {
      throw new Exception('Page only allows file size of ' . f::niceSize($filesettings->size()));
    }

    // Files blueprint option 'width'
    if($file->type() == 'image' and $filesettings->width() and $file->width() > $filesettings->width()) {
      throw new Exception('Page only allows image width of ' . $filesettings->width().'px');
    }

    // Files blueprint option 'height'
    if($file->type() == 'image' and $filesettings->height() and $file->height() > $filesettings->height()) {
      throw new Exception('Page only allows image height of ' . $filesettings->height().'px');
    } 

  }

}