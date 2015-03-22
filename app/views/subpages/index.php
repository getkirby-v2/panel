<?php echo $topbar ?>

<div class="section grey">
  <h2 class="hgroup cf">
    <span class="hgroup-title">
      <?php if($page->isSite()): ?>
        <?php _l('subpages') ?>
      <?php else: ?>
        <?php _l('subpages.index.headline') ?> <a href="<?php echo purl($page, 'show') ?>"><?php __($page->title()) ?></a>
      <?php endif ?>
    </span>
    <span class="hgroup-options shiv shiv-dark shiv-left cf">

      <a class="hgroup-option-left" href="<?php echo purl($page, 'show') ?>">
        <?php i('arrow-circle-left', 'left') . _l('subpages.index.back') ?>
      </a>

      <?php if($addbutton): ?>
      <a title="+" data-shortcut="+" class="hgroup-option-right" href="<?php echo purl('subpages/add/' . $page->id()) ?>">
        <?php i('plus-circle', 'left') ?>
        <?php _l('subpages.index.add') ?>
      </a>
      <?php endif ?>

    </span>
  </h2>

  <?php if($page->hasChildren()): ?>
  <div class="grid subpages-grid">

    <div class="grid-item">
      <h3><a href="<?php echo $baseurl . '/visible:1/invisible:' . $invisible->pagination()->page() ?>"><?php _l('subpages.index.visible') ?></a></h3>

      <div class="dropzone subpages">
        <div class="items<?php e($sortable, ' sortable') ?>" data-flip="<?php echo $flip ?>" data-start="<?php echo $visible->pagination()->numStart() ?>" data-total="<?php echo $visible->pagination()->items() ?>" id="visible-children">

          <?php
          foreach($visible as $subpage):
            echo new Snippet('subpages/subpage', array(
              'subpage'       => $subpage,
              'editbutton'    => $visibleEditBtns[$subpage->uid()],
              'editbuttons'   => count(array_unique($visibleEditBtns)) != 1,
              'deletebutton'  => $visibleDeleteBtns[$subpage->uid()],
              'deletebuttons' => count(array_unique($visibleDeleteBtns)) != 1
              ));
          endforeach;
          ?>

        </div>
      </div>

      <?php echo $visiblePagination ?>

      <?php if(!$visible->count()): ?>
      <div class="subpages-help subpages-help-left marginalia text">
        <?php _l('subpages.index.visible.help') ?>
      </div>
      <?php endif ?>

    </div><!--

 --><div class="grid-item">
      <h3><a href="<?php echo $baseurl . '/visible:' . $visible->pagination()->page() . '/invisible:1' ?>"><?php _l('subpages.index.invisible') ?></a></h3>

      <div class="dropzone subpages">
        <div class="items<?php e($sortable, ' sortable') ?>" id="invisible-children">

          <?php
          foreach($invisible as $subpage):
            echo new Snippet('subpages/subpage', array(
              'subpage'       => $subpage,
              'editbutton'    => $invisibleEditBtns[$subpage->uid()],
              'editbuttons'   => count(array_unique($invisibleEditBtns)) != 1,
              'deletebutton'  => $invisibleDeleteBtns[$subpage->uid()],
              'deletebuttons' => count(array_unique($invisibleDeleteBtns)) != 1
            ));
          endforeach;
          ?>

        </div>
      </div>

      <?php echo $invisiblePagination ?>

      <?php if(!$invisible->count() and $sortable): ?>
      <div class="subpages-help subpages-help-right marginalia text">
        <?php _l('subpages.index.invisible.help') ?>
      </div>
      <?php endif ?>

    </div>

  </div>

  <?php else: ?>

  <div class="instruction">
    <div class="instruction-content">
      <p class="instruction-text"><?php _l('subpages.index.add.first.text') ?></p>
      <?php if($addbutton) : ?>
        <a data-shortcut="+" class="btn btn-rounded" href="<?php echo purl('subpages/add/' . $page->id()) ?>">
          <?php _l('subpages.index.add.first.button') ?>
        </a>
      <?php endif ?>
    </div>
  </div>

  <?php endif ?>

</div>
