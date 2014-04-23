<?php

class App {

  static public $site;
  static public $path;
  static public $routes = array();
  static public $router;
  static public $route;
  static public $language;

  static public function configure() {

    if(is_null(static::$site)) {
      static::$site = kirby::panelsetup();
    }

    // some config stuff
    c::set('root.panel',      dirname(path('app')));
    c::set('root.blueprints', c::get('root.site') . DS . 'blueprints');
    c::set('root.accounts',   c::get('root.site') . DS . 'accounts');

    // load all available routes
    static::$routes = array_merge(static::$routes, require(path('app')   . DS . 'routes' . DS . 'api.php'));
    static::$routes = array_merge(static::$routes, require(path('app')   . DS . 'routes' . DS . 'views.php'));

    // start the router
    static::$router = new Router();
    static::$router->register(static::$routes);

    if($language = server::get('http_language')) {
      static::$language = $language;
    }

    // register router filters
    static::$router->filter('auth', function() {
      if(!static::$site->user()) {
        go('panel/login');
      }
    });

    // check for a completed installation
    static::$router->filter('isInstalled', function() {
      if(static::$site->users()->count() == 0) {
        go('panel/install');
      }
    });

    // only use the fragments of the path without params
    static::$path = implode('/', (array)url::fragments(detect::path()));

  }

  static public function launch() {

    static::$route = static::$router->run(static::$path);

    // react on invalid routes
    if(!static::$route) {
      throw new Exception('Invalid route');
    }

    // let's find the controller and controller action
    $controllerParts  = str::split(static::$route->action(), '::');
    $controllerUri    = $controllerParts[0];
    $controllerAction = $controllerParts[1];
    $controllerFile   = path('app.controllers') . DS . strtolower(str_replace('Controller', '', $controllerUri)) . '.php';
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

    // call the action and pass all arguments from the router
    $response = call(array($controller, $controllerAction), static::$route->arguments());

    // check for a valid response object
    if(is_a($response, 'Response')) {
      echo $response;
    } else {
      echo new Response($response);
    }

  }

}