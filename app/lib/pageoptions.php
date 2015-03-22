<?php

class PageOptions {

  public $page;
  public $blueprint;
  public $user;
  public $isSite;

  public function __construct($page) {
    $this->page       = $page;
    $this->blueprint  = blueprint::find($this->page);
    $this->user       = site()->user();
    $this->isSite     = ($this->page == site());
  }

  // Returns the page's preview link depending on the preview blueprint option
  public function previewLink() {
    if($previewSetting = $this->blueprint->preview()) {
      switch($previewSetting) {
        case 'parent':
          return $this->page->parent() ? $this->page->parent()->url() : $this->page->url();
          break;
        case 'first-child':
          return $this->page->children()->first() ? $this->page->children()->first()->url() : false;
          break;
        case 'last-child':
          return $this->page->children()->last()  ? $this->page->children()->last()->url() : false;
          break;
        default:
          return $this->page->url();
          break;
      }
    } else {
      return null;
    }
  }


  /**
   *  Helpers for permissions checking
   */

  public function canSave() {
    if ($this->isSite)
      $permission = $this->user->hasPermission('site.update');
    else
      $permission = $this->user->hasPermission('page.update');

    return $permission and $this->blueprint->can('update', $this->user->role());
  }

  public function canEdit() {
    return (
             $this->user->hasPermission('page.update') or
             $this->user->hasPermission('page.changeurl') or
             $this->user->hasPermission('page.hide')
           ) and (
             $this->blueprint->can('update', $this->user) or
             $this->blueprint->can('changeurl', $this->user) or
             $this->blueprint->can('hide', $this->user)
           );
  }

  public function canChangeURL() {
    return $this->user->hasPermission('page.changeurl') and
           $this->blueprint->can('changeurl', $this->user->role());
  }

  public function canHide() {
    return $this->user->hasPermission('page.hide') and
           $this->blueprint->can('hide', $this->user->role());
  }

  public function canDelete() {
    return !$this->page->hasChildren() and
           $this->page->isDeletable() and
           $this->user->hasPermission('page.delete') and
           $this->blueprint->can('delete', $this->user->role());
  }

  // Subpages

  public function canSubpagesAdd() {
    return !api::maxPages($this->page, $this->blueprint->pages()->max()) and
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

    return (
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
    return $this->user->hasPermission('page.sort') and
           $this->blueprint->pages()->can('sort', $this->user->role());
  }

  public function getSubpagesBtnsList($subpages) {
    $btns = array('edit' => array(), 'delete' => array());
    foreach ($subpages as $index => $subpage) {
      $subpageOptions = new PageOptions($subpage);
      $btns['edit'][$subpage->uid()] = $subpageOptions->canEdit();
      $btns['delete'][$subpage->uid()] = $subpageOptions->canDelete();
    }
    return $btns;
  }

  // Files

  public function canFilesAdd() {
    if ($this->isSite)
      $permission = $this->user->hasPermission('site.update');
    else
      $permission = $this->user->hasPermission('file.upload');

    return $permission and $this->blueprint->files()->can('create', $this->user->role());
  }

  public function canFilesSave() {
    if ($this->isSite) $permission = $this->user->hasPermission('site.update');
    else $permission = $this->user->hasPermission('file.update');

    return $permission and $this->blueprint->files()->can('update', $this->user->role());
  }

  public function canFilesEdit() {
    if ($this->isSite)
      $permissions = $this->user->hasPermission('site.update');
    else
      $permissions = $this->user->hasPermission('file.replace') or
                     $this->user->hasPermission('file.update') or
                     $this->user->hasPermission('file.delete');

    return $permissions and
           (
             $this->blueprint->files()->can('replace', $this->user->role()) or
             $this->blueprint->files()->can('update', $this->user->role()) or
             $this->blueprint->files()->can('delete', $this->user->role())
           );
  }

  public function canFilesReplace() {
    if ($this->isSite)
      $permission = $this->user->hasPermission('site.update');
    else
      $permission = $this->user->hasPermission('file.replace');

    return $permission and $this->blueprint->files()->can('replace', $this->user->role());
  }

  public function canFilesSort() {
    return $this->canFilesSave();
  }

  public function canFilesDelete() {
    if ($this->isSite)
      $permission = $this->user->hasPermission('site.update');
    else
      $permission = $this->user->hasPermission('file.delete');

    return $permission and $this->blueprint->files()->can('delete', $this->user->role());
  }


  // site blueprint: metatags
  public function canMetatagsUpdate() {
    return $this->user->hasPermission('site.update') and
           $this->blueprint->can('update', $this->user->role());
  }

}
