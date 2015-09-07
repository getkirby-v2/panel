<?php if($pages->count()): ?>
<section class="search-section">
  <ul class="nav nav-list">
    <?php foreach($pages as $page): ?>
    <li>
      <a href="<?php echo $page->url('edit') ?>">
        <?php i('file-o', 'left') ?><?php __($page->title()) ?>
      </a>
    </li>
    <?php endforeach ?>
  </ul>
</section>
<?php endif ?>

<?php if($users->count()): ?>
<section class="search-section">
  <ul class="nav nav-list">
    <?php foreach($users as $user): ?>
    <li>
      <a href="<?php echo $user->url('edit') ?>">
        <?php i('user', 'left') ?>
        <?php __(ucfirst($user->username())) ?>
      </a>
    </li>
    <?php endforeach ?>
  </ul>
</section>
<?php endif ?>