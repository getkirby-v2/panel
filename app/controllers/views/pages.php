<?php

class PagesController extends Controller {

  public function add($id, $template = null) {

    $parent = $this->page($id);

    if(empty($template)) {

      $blueprint = blueprint::find($parent);

      return modal('pages/add', array(
        'parent'    => $parent,
        'templates' => $blueprint->pages()->template(),
        'back'      => purl($parent, 'show')
      ));

    } else {

      $data = PageData::createByBlueprint($template, array(
        'title' => '(Untitled)'
      ));

      $page = $parent->children()->create(str::random(32), $template, $data);

      s::set('draft', $page->id());

      $this->redirect($page, 'show');

    }

  }

  public function show($id) {

    $editor = new PageEditor($id);    

    return screen('pages/show', $editor->page(), $editor->content());

  }

  public function delete($id) {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);

    if($page->isHomePage()) {
      return modal('error', array(
        'headline' => l('pages.delete.error.home.headline'),
        'text'     => l('pages.delete.error.home.text'),
        'back'     => purl($page, 'show')
      ));
    } else if($page->isErrorPage()) {
      return modal('error', array(
        'headline' => l('pages.delete.error.error.headline'),
        'text'     => l('pages.delete.error.error.text'),
        'back'     => purl($page, 'show')
      ));
    } else if($page->hasChildren()) {
      return modal('error', array(
        'headline' => l('pages.delete.error.children.headline'),
        'text'     => l('pages.delete.error.children.text'),
        'back'     => purl($page, 'show')
      ));
    } else if(!$blueprint->deletable()) {
      return modal('error', array(
        'headline' => l('pages.delete.error.blocked.headline'),
        'text'     => l('pages.delete.error.blocked.text'),
        'back'     => purl($page, 'show')
      ));
    } else {

      $page = $this->page($id);
      $form = panel()->form('pages/delete');
      $self = $this;

      $form->on('submit', function($form) use($page, $self) {

        $parent   = $page->parent();
        $subpages = new Subpages($parent);

        try {
          $subpages->delete($page);

          // remove unsaved changes
          PageStore::discard($page);

          $self->redirect($parent, 'show');

        } catch(Exception $e) {
          $form->alert($e->getMessage());
        }

      });

      $form->fields->page->value = $page->title();
      $form->fields->page->help  = $page->id();

      $form->style('delete');
      $form->cancel($page, 'show');

      return modal('pages/delete', array(
        'form' => $form
      ));

    }

  }

  public function keep($id) {
    $page = $this->page($id);
    PageStore::keep($page);
    $this->redirect($page, 'show');
  }

  public function discard($id) {
    $page = $this->page($id);
    PageStore::discard($page);
    $this->redirect($page, 'show');
  }

  public function url($id) {

    $page = $this->page($id);

    if($page->isHomePage() or $page->isErrorPage()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'The URL for the home and error pages cannot be changed',
      ));
    } else {

      $form = panel()->form('pages/url');
      $self = $this;

      // form action
      $form->on('submit', function($form) use($page, $self) {

        $changes = PageStore::fetch($page);
        PageStore::discard($page);

        try {

          if(site()->multilang() and site()->language()->code() != site()->defaultLanguage()->code()) {
            $page->update(array(
              'URL-Key' => get('uid')
            ));
          } else {
            $page->move(get('uid'));
          }

          PageStore::update($page, $changes);

          // hit the hook
          kirby()->trigger('panel.page.move', $page);
          $self->redirect($page, 'show');

        } catch(Exception $e) {
          $form->alert($e->getMessage());
        }

      });

      // label option
      $option = new Brick('a', icon('plus-circle', 'left') . l('pages.url.uid.label.option'), array(
        'class'      => 'btn btn-icon label-option',
        'href'       => '#',
        'data-title' => $page->title()
      ));

      // url preview
      $preview = new Brick('div', '', array('class' => 'uid-preview'));
      $preview->html(
        ltrim($page->parent()->uri() . '/', '/') . 
        '<span>' . $page->slug() . '</span>'
      );

      $form->fields->uid->label  = l('pages.url.uid.label');
      $form->fields->uid->label .= $option;
      $form->fields->uid->value  = $page->slug();
      $form->fields->uid->help   = (string)$preview;

      $form->buttons->submit->val(l('change'));

      $form->cancel($page, 'show');

      return modal('pages/url', array(
        'form' => $form
      ));

    }

  }

  public function toggle($id) {

    $page = $this->page($id);

    if($page->isErrorPage()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'The status of the error page cannot be changed',
      ));
    }

    $form = panel()->form('pages/toggle');
    $self = $this;

    $form->on('submit', function($form) use($page, $self) {

      $parent   = $page->parent();
      $subpages = new Subpages($parent);

      try {

        if($page->isVisible()) {
          $subpages->hide($page);
        } else {
          $subpages->sort($page, get('position', 'last'));          
        }

        $self->redirect($page, 'show');

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    $form->buttons->submit->value     = l('change');
    $form->buttons->submit->autofocus = true;

    $form->cancel($page, 'show');

    if($page->isVisible()) {
      $form->fields->confirmation->text = l('pages.toggle.hide');      
    } else {
      
      $form->fields->confirmation->text = l('pages.toggle.publish');      

      $parent    = $page->parent();
      $blueprint = blueprint::find($parent);

      if($blueprint->pages()->num()->mode() == 'default') {

        $siblings = api::subpages($parent->children()->visible(), $blueprint);
        $position = new Brick('ul');
        $position->addClass('position-list');

        $n = 0;

        foreach($siblings as $sibling) {
          $n++;
          $position->append('<li class="position-list-input"><label><input id="page-position-' . $n . '" name="position" value="' . $n . '" type="radio"></label></li>');
          $position->append('<li class="position-list-label"><label for="page-position-' . $n . '"><small>' . $n . '.</small> ' . $sibling->title()->html() . '</label></li>');
        }

        $n++;
        $position->append('<li class="position-list-input"><label><input checked name="position" value="' . $n . '" type="radio"></label></li>');
        
        $form->fields->confirmation->text .= $position;

      }

    }

    return modal('pages/toggle', array(
      'page' => $page, 
      'form' => $form
    ));

  }

  public function search($id = '/') {

    $page = $this->page($id);

    return screen('pages/search', $page, array(
      'page' => $page
    ));

  }

  protected function page($id = '/') {

    $page = $id == '/' ? site() : page($id);

    if($page) {
      return $page;
    } else {
      throw new Exception('The page could not be found');
    }

  }

}