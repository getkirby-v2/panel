<?php

class FieldController extends Kirby\Panel\Controllers\Base {

  public function route($id, $fieldName, $fieldType, $path) {

    $page  = $this->page($id);
    $form  = $page->form('edit', function() {});
    $field = $form->fields()->$fieldName;

    if(!$field or $field->type() !== $fieldType) {
      throw new Exception('Invalid field');
    }

    $routes = $field->routes();
    $router = new Router($routes);
    
    if($route = $router->run($path)) {

      if(is_callable($route->action()) and is_a($route->action(), 'Closure')) {
        return call($route->action(), $route->arguments());
      } else {
 
        $controllerFile = $field->root() . DS . 'controller.php';
        $controllerName = $fieldType . 'FieldController';

        if(!file_exists($controllerFile)) {
          throw new Exception('The field controller file is missing');
        }

        require_once($controllerFile);

        if(!class_exists($controllerName)) {
          throw new Exception('The field controller class is missing');
        }

        $controller = new $controllerName($page, $field);

        return call(array($controller, $route->action()), $route->arguments());

      }
 
    } else {
      throw new Exception('Invalid field route');
    }

  }

}