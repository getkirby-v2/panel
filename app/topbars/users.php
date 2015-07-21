<?php 

return function($topbar, $users) {
  $topbar->append(purl('users'), l('users'));
};