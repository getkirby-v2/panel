<div class="section">
  <h2 class="hgroup cf"><?php _l('error.headline') ?></h2>
  <p><?php __($text) ?></p>

  <pre>
    <code><?php var_dump($exception->getTrace()) ?></code>
  </pre>

</div>