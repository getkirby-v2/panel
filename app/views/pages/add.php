<style>
.templates {
  border-top: 2px solid #ddd;
}
.templates li a {
  padding: .5em 0;
  border-bottom: 2px solid #ddd;
  color: #777;
}
.templates li a:hover {
  color: #000;
}
.templates li i {
  float: right;
  margin-top: .3em;
  color: #000;
}

</style>
<div class="modal-content">
  <div class="form">

    <div class="field">
      <div class="label"><?php _l('pages.add.title.label') ?>…</div>
      <ul class="templates nav">
        <?php foreach($templates as $template): ?>
        <li>
          <a href="<?php _u($parent, 'add/' . $template->name()) ?>">
            <?php __($template->title()) ?>
            <?php i('plus-circle') ?>
          </a>
        </li>
        <?php endforeach ?>
      </ul>
    </div>

    <div class="buttons buttons-centered">
      <a href="<?php __($back) ?>" class="btn btn-rounded btn-cancel">Cancel</a>
    </div>

  </div>
</div>