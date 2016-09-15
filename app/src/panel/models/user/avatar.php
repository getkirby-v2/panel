<?php

namespace Kirby\Panel\Models\User;

use Media;
use Exception;
use Error;
use Thumb;

use Kirby\Panel\Event;
use Kirby\Panel\Upload;
use Kirby\Panel\Models\User;

class Avatar extends \Avatar {

  public function __construct(User $user) {

    parent::__construct($user);

    if(!$this->exists()) {
      $this->root = $this->user->avatarRoot('{safeExtension}');
      $this->url  = purl('assets/images/avatar.png');
    }

  }

  public function form($action, $callback) {
    return panel()->form('avatars/' . $action, $this, $callback);
  }

  public function upload() {

    if(!panel()->user()->isAdmin() and !$this->user->isCurrent()) {
      throw new Exception(l('users.avatar.error.permission'));
    }

    $root = $this->exists() ? $this->root() : $this->user->avatarRoot('{safeExtension}');    

    // create the upload event
    $event = $this->event('upload');

    // check for permissions
    $event->check();

    $upload = new Upload($root, array(
      'accept' => function($upload) {
        if($upload->type() != 'image') {
          throw new Error(l('users.avatar.error.type'));
        }
      }
    ));

    if(!$upload->file()) {
      throw $upload->error();
    }

    // flush the cache in case if the user data is 
    // used somewhere on the site (i.e. for profiles)
    kirby()->cache()->flush();

    kirby()->trigger($event, $this);

  }

  public function delete() {

    if(!$this->exists()) {
      return true;
    }

    // create the delete event
    $event = $this->event('delete');

    // check for permissions
    $event->check();

    // delete the avatar file
    if(!parent::delete()) {
      throw new Exception(l('users.avatar.delete.error'));
    } 

    // flush the cache in case if the user data is 
    // used somewhere on the site (i.e. for profiles)
    kirby()->cache()->flush();

    kirby()->trigger($event, $this);

  }

  public function event($type, $args = []) {  
    return new Event('panel.avatar.' . $type, array_merge([
      'user'   => $this->user,
      'avatar' => $this
    ], $args));
  }

}