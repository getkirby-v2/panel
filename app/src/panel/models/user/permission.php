<?php

namespace Kirby\Panel\Models\User;

use Kirby\Panel\Models\Page\Blueprint;

class Permission {

  public $user;
  public $role;
  public $page;
  public $blueprint;


  public function __construct($user, $page = null) {
    $this->user   = $user;

    if (!is_null($page)) {
      $this->page = $page;
    }
  }


  // Site
  public function updateSite() {
    return
      $this->user->hasPermission('panel.site.update');
  }


  // Pages
  public function editPage() {
    return
      $this->updatePage() or
      $this->movePage() or
      $this->hidePage() or
      $this->deletePage();
  }

  public function updatePage() {
    return
      $this->user->hasPermission('panel.page.update');
  }

  public function movePage() {
    return
      $this->user->hasPermission('panel.page.move');
  }

  public function hidePage() {
    return
      $this->user->hasPermission('panel.page.hide');
  }

  public function deletePage() {
    return
      $this->user->hasPermission('panel.page.delete');
  }


  // Subpages
  public function createSubpages() {
    return
      $this->user->hasPermission('panel.page.create');
  }

  public function editSubpages() {
    foreach($this->page->children() as $subpage) {
      $this->page = $subpage;
      if($this->editPage()) return true;
    }
    return false;
  }

  public function sortSubpages() {
    return
      $this->user->hasPermission('panel.page.sort');
  }


  // Files
  public function editFile() {
    return
      $this->replaceFile() or
      $this->updateFile() or
      $this->deleteFile();
  }

  public function uploadFile() {
    return
      $this->user->hasPermission('panel.file.upload');
  }

  public function replaceFile() {
    return
      $this->user->hasPermission('panel.file.replace');
  }

  public function updateFile() {
    return
      $this->user->hasPermission('panel.file.update');
  }

  public function deleteFile() {
    return
      $this->user->hasPermission('panel.file.delete');
  }


  // Users

  public function addUser() {
    return $this->user->hasPermission('panel.user.add');
  }

  public function editUser() {
    return
      $this->user->hasPermission('panel.user.edit') or
      $this->roleUser();
  }

  public function roleUser() {
    return $this->user->hasPermission('panel.user.role');
  }

  public function deleteUser() {
    return $this->user->hasPermission('panel.user.delete');
  }


}
