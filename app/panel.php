<?php

class Panel {

  static public $version = '2.0.6';
  static public $instance;

  public $kirby;
  public $site;
  public $path;
  public $roots;
  public $routes = array();
  public $router = null;
  public $route  = null;
  public $language = null;
  public $languages = null;

  static public function instance() {
    return static::$instance;
  }

  static public function version() {
    return static::$version;
  }

  public function __construct($kirby, $dir) {

    static::$instance = $this;

    $this->kirby = $kirby;
    $this->site  = $kirby->site();
    $this->roots = new Panel\Roots($dir);
    $this->urls  = new Panel\Urls($kirby->urls()->index() . '/' . basename($dir));

    // load all Kirby extensions (methods, tags, smartypants)
    $this->kirby->extensions();

    $this->load();

    // load all available routes
    $this->routes = array_merge($this->routes, require($this->roots->routes . DS . 'api.php'));
    $this->routes = array_merge($this->routes, require($this->roots->routes . DS . 'views.php'));

    // setup the blueprint root
    blueprint::$root = $this->kirby->roots()->blueprints();

    // setup the form plugin
    form::setup($this->roots->fields, $this->kirby->roots()->fields());

    // start the router
    $this->router = new Router($this->routes);

    // register router filters
    $this->router->filter('auth', function() use($kirby) {

      $user = $kirby->site()->user();

      if(!$user or !$user->hasPanelAccess()) {
        if($user) $user->logout();
        go('panel/login');
      } 
    });

    // check for a completed installation
    $this->router->filter('isInstalled', function() use($kirby) {
      if($kirby->site()->users()->count() == 0) {
        go('panel/install');
      }
    });

  }

  public function kirby() {
    return $this->kirby;
  }

  public function site() {
    return $this->site;
  }

  public function roots() {
    return $this->roots;
  }

  public function urls() {
    return $this->urls;
  }

  public function form($id, $data = array()) {
    $fields = data::read($this->roots->forms . DS . $id . '.php', 'yaml');
    return new Form($fields, $data);
  }

  public function load() {

    load(array(

      // mvc
      'view'         => $this->roots->lib . DS . 'view.php',
      'controller'   => $this->roots->lib . DS . 'controller.php',
      'layout'       => $this->roots->lib . DS . 'layout.php',
      'snippet'      => $this->roots->lib . DS . 'snippet.php',

      // panel stuff
      'api'          => $this->roots->lib . DS . 'api.php',
      'assets'       => $this->roots->lib . DS . 'assets.php',
      'fieldoptions' => $this->roots->lib . DS . 'fieldoptions.php',
      'filedata'     => $this->roots->lib . DS . 'filedata.php',
      'form'         => $this->roots->lib . DS . 'form.php',
      'history'      => $this->roots->lib . DS . 'history.php',
      'installation' => $this->roots->lib . DS . 'installation.php',
      'pagedata'     => $this->roots->lib . DS . 'pagedata.php',

      // blueprint stuff
      'blueprint'         => $this->roots->lib . DS . 'blueprint.php',
      'blueprint\\pages'  => $this->roots->lib . DS . 'blueprint' . DS . 'pages.php',
      'blueprint\\files'  => $this->roots->lib . DS . 'blueprint' . DS . 'files.php',
      'blueprint\\fields' => $this->roots->lib . DS . 'blueprint' . DS . 'fields.php',
      'blueprint\\field'  => $this->roots->lib . DS . 'blueprint' . DS . 'field.php',

    ));

  }

  public function languages() {

    $languages = new Collection;
    $root      = $this->roots()->languages();

    foreach(dir::read($root) as $file) {

      // skip invalid language files
      if(f::extension($file) != 'php') continue;

      // fetch all strings from the language file
      $strings = require($root . DS . $file);

      // skip invalid language files
      if(!is_array($strings)) continue;

      // create the language object
      $language = new Obj($strings);
      $language->code = str_replace('.php', '', $file);
      $languages->set($language->code, $language);
    
    }

    return $languages;

  }

  public function language() {
    return $this->language;
  }

  public function i18n() {

    // load the interface language file
    if($user = $this->site()->user()) {
      $this->language = $user->language();
    } else {
      $this->language = $this->kirby()->option('panel.language', 'en');
    }

    $translation = require($this->roots()->languages() . DS . 'en.php');
    $translation = array_merge($translation, require($this->roots()->languages() . DS . $this->language . '.php'));

    // set all language variables
    l::$data = $translation['data'];

  }

  public function multilang() {

    if(!$this->site->multilang()) {
      $this->site->visit('/');
      return true;
    }

    if($language = server::get('http_language') or $language = s::get('lang')) {
      $this->site->visit('/', $language);
    } else {
      $this->site->visit('/');
    }

    s::set('lang', $this->site->language()->code());

  }

  public function launch($path = null) {

    // set the timezone for all date functions
    date_default_timezone_set($this->kirby->options['timezone']);

    $this->i18n();
    $this->multilang();

    $this->path  = $this->kirby->path();
    $this->route = $this->router->run($this->path);

    // react on invalid routes
    if(!$this->route) {
      throw new Exception('Invalid route');
    }

    // let's find the controller and controller action
    $controllerParts  = str::split($this->route->action(), '::');
    $controllerUri    = $controllerParts[0];
    $controllerAction = $controllerParts[1];
    $controllerFile   = $this->roots->controllers . DS . strtolower(str_replace('Controller', '', $controllerUri)) . '.php';
    $controllerName   = basename($controllerUri);

    // react on missing controllers
    if(!file_exists($controllerFile)) {
      throw new Exception('Invalid controller');
    }

    // load the controller
    require_once($controllerFile);

    // check for the called action
    if(!method_exists($controllerName, $controllerAction)) {
      throw new Exception('Invalid action');
    }

    // run the controller
    $controller = new $controllerName;

    try {
      // call the action and pass all arguments from the router
      $response = call(array($controller, $controllerAction), $this->route->arguments());
    } catch(Exception $e) {

      $file = $this->roots->controllers . DS . substr($controllerUri, 0, strpos($controllerUri, '/') + 1) . 'errors.php';

      require_once($file);

      $action     = (isset($this->route->modal) and $this->route->modal) ? 'modal' : 'index';
      $controller = new ErrorsController;
      $message    = $e->getMessage() . ' in ' . $e->getFile() . ' on Line ' . $e->getLine();
      $response   = call(array($controller, $action), array($message));

    }

    ob_start();

    // check for a valid response object
    if(is_a($response, 'Response')) {
      echo $response;
    } else {
      echo new Response($response);
    }

    ob_end_flush();

  }

}