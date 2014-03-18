<?php 

return array(

  'slug' => function() {
    die(str::slug(get('string')));
  }

);