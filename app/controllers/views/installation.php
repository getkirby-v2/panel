<?php

class InstallationController extends Controller {

  public function index() {

    if(site()->users()->count() > 0) {
      $this->redirect('login');
    } else if($problems = installation::check()) {
      return $this->problems($problems);
    } else {
      return $this->signup();
    }

  }

  protected function problems($problems) {

    $info = new Brick('ol');

    foreach($problems as $problem) {
      $info->append('<li>' . $problem . '</li>');        
    }

    $form = panel()->form('installation/check');    
    
    // add the list of problems to the info field
    $form->fields->info->text = (string)$info;

    // setup the retry button
    $form->buttons->submit->value     = l('installation.check.retry');
    $form->buttons->submit->autofocus = true;

    $form->style('centered');
    $form->alert(l('installation.check.text'));

    return modal('installation/index', compact('form'));

  }

  protected function signup() {

    $self = $this;
    $form = panel()->form('installation/signup', array('language' => kirby()->option('panel.language', 'en')));

    $form->data('autosubmit', 'native');
    $form->style('centered');

    $form->buttons->submit->value = l('installation.signup.button');

    foreach(panel()->languages() as $lang) {
      $form->fields()->get('language')->options[$lang->code()] = $lang->title();
    }

    $form->on('submit', function($form) use($self) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      try {

        // fetch all the form data
        $data = $form->serialize();

        // make sure that the first user is an admin
        $data['role'] = 'admin';

        // try to create the new user
        $user = panel()->site()->users()->create($data);

        // store the new username for the login screen
        s::set('username', $user->username());

        // try to login the user automatically
        if($user->hasPanelAccess()) {
          $user->login($data['password']);
        }

        // redirect to the login
        $self->redirect('login/welcome');

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return modal('installation/index', compact('form'));

  }

}