<?php

class PageOptions {

  public $page;
  public $blueprint;
  public $user;

  public function __construct($page) {
    $this->page       = $page;
    $this->blueprint  = blueprint::find($this->page);
    $this->user       = site()->user();
  }

  /**
   *  Helpers for permissions checking
   */

  public function canSave() {
    return  $this->user->hasPermission('page.update') and
            $this->blueprint->can('update', $this->user->role());
  }

  public function canEdit() {
    return  (
              $this->user->hasPermission('page.update') or
              $this->user->hasPermission('page.changeurl') or
              $this->user->hasPermission('page.hide') or
              $this->user->hasPermission('page.delete')
            ) and (
              $this->blueprint->can('update', $this->user) or
              $this->blueprint->can('changeurl', $this->user) or
              $this->blueprint->can('hide', $this->user) or
              $this->blueprint->can('delete', $this->user)
            );
  }

  public function canChangeURL() {
    return  $this->user->hasPermission('page.changeurl') and
            $this->blueprint->can('changeurl', $this->user->role());
  }

  public function canHide() {
    return  $this->user->hasPermission('page.hide') and
            $this->blueprint->can('hide', $this->user->role());
  }

  public function canDelete() {
    return  !$this->page->hasChildren() and
            $this->page->isDeletable() and
            $this->user->hasPermission('page.delete') and
            $this->blueprint->can('delete', $this->user->role());
  }

  // Subpages

  public function canSubpagesAdd() {
    return  !api::maxPages($this->page, $this->blueprint->pages()->max()) and
            $this->user->hasPermission('page.create') and
            $this->blueprint->pages()->can('create', $this->user->role());
  }

  public function canSubpagesEdit() {
    $subpagesEditable = false;
    foreach ($this->page->children() as $subpage) {
      $sp_blueprint = blueprint::find($subpage);
      if ($sp_blueprint->can('update', $this->user) or
          $sp_blueprint->can('changeurl', $this->user) or
          $sp_blueprint->can('hide', $this->user) or
          $sp_blueprint->can('delete', $this->user))
          $subpagesEditable = true;
    }

    return  (
              $this->user->hasPermission('page.update') or
              $this->user->hasPermission('page.changeurl') or
              $this->user->hasPermission('page.sort') or
              $this->user->hasPermission('page.hide') or
              $this->user->hasPermission('page.delete')
            ) and (
              $subpagesEditable == true
            );
  }

  public function canSubpagesSort() {
    return  $this->user->hasPermission('page.sort') and
            $this->blueprint->pages()->can('sort', $this->user->role());
  }

  // Files

  public function canFilesAdd() {
    return  $this->user->hasPermission('file.upload') and
            $this->blueprint->files()->can('create', $this->user->role());
  }

  public function canFilesSave() {
    return  $this->user->hasPermission('file.update') and
            $this->blueprint->files()->can('update', $this->user->role());
  }

  public function canFilesEdit() {
    return  (
              $this->user->hasPermission('file.replace') or
              $this->user->hasPermission('file.update') or
              $this->user->hasPermission('file.delete')
            ) and (
              $this->blueprint->files()->can('replace', $this->user->role()) or
              $this->blueprint->files()->can('update', $this->user->role()) or
              $this->blueprint->files()->can('delete', $this->user->role())
            );
  }

  public function canFilesReplace() {
    return  $this->user->hasPermission('file.replace') and
            $this->blueprint->files()->can('replace', $this->user->role());
  }

  public function canFilesSort() {
    return  $this->canFilesSave();
  }

  public function canFilesDelete() {
    return  $this->user->hasPermission('file.delete') and
            $this->blueprint->files()->can('delete', $this->user->role());
  }


}
