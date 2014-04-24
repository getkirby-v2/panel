<?php echo $header ?>

<div class="content manager">

  <header class="manager__header">
    <h1 class="alpha"><?php echo l('users.index.headline') ?></h1>
    <a class="manager__toggle" ui-sref="users.modal.add"><i class="fa fa-plus-circle"></i> <span><?php echo l('users.index.add') ?></span></a>
  </header>

  <div class="users">
    <article class="user" ng-repeat="user in users">
      <figure class="user__avatar">
        <a ui-sref="users.modal.avatar({username: user.username})">
          <img ng-show="user.avatar" ng-src="{{user.avatar}}">
          <i ng-show="!user.avatar" class="fa fa-user fa-lg"></i>
        </a>
      </figure>

      <strong class="user__username">{{user.username}}</strong>
      <small class="user__email">{{user.email}}</small>

      <nav class="manager__options user__options">
        <a ui-sref="users.modal.edit({username : user.username})">
          <i class="fa fa-pencil"></i> <?php echo l('users.index.edit') ?>
        </a><!--
     --><a ui-sref="users.modal.delete({username : user.username})">
          <i class="fa fa-trash-o"></i> <?php echo l('users.index.delete') ?>
        </a>
      </nav>

    </article>
  </div>

</div>