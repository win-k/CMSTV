<div class="box">
  <header>
    <h1><?php echo __('PCテーマの編集') ?></h1>
  </header>
  <div class="inner">

    <?php
    echo $this->element('editor_set', array(
      'type' => 'pc',
    ));
    ?>

  </div>
</div>

