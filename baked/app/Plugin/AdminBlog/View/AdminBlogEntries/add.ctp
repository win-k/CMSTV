<div class="box">
  <header>
    <h1><?php echo __('新規記事') ?></h1>
  </header>
  <div class="inner">
    <?php
    $url = '/admin/blog/entries/add';
    echo $this->Form->create('Entry', array(
      'class' => 'form-01 bk-general',
      'url' => $url,
    ));
    if (!empty($this->data['Entry']['id'])) {
      echo $this->Form->input('id', array(
        'type' => 'hidden',
      ));
    }
    echo $this->Baked->hiddenToken();
    ?>
    <?php
    $blogOptions = array();
    foreach ($blogs as $blog) {
      $blogOptions[$blog['Page']['id']] = sprintf('%s / %s', $blog['Page']['name'], $blog['Page']['title']);
    }
    echo $this->Form->input('page_id', array(
      'label' => __('対象ブログ'),
      'options' => $blogOptions,
    ));
    echo $this->Form->input('title', array(
      'label' => __('タイトル'),
    ));
    echo $this->Form->input('published', array(
      'label' => __('公開日時'),
      'type' => 'text',
      'value' => Baked::dateFormat($this->data['Entry']['published'], 'Y-m-d H:i'),
    ));
    ?>
    <div class="full">
      <ul id="editor-controller">
        <li data-open-editor="#editor-body1"><a href="javascript:;"><i class="icon icon-file-alt"></i><?php echo __('記事を書く') ?></a></li>
        <li data-open-editor="#editor-body2"><a href="javascript:;"><i class="icon icon-copy"></i><?php echo __('続きを書く') ?></a></li>
      </ul>
      <div id="editor-body1" class="editor">
        <?php
        echo $this->Form->input('body1', array(
          'label' => FALSE,
        ));
        ?>
      </div>
      <div id="editor-body2" class="editor">
        <?php
        echo $this->Form->input('body2', array(
          'label' => FALSE,
        ));
        ?>
      </div>
    </div>

    <button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button><?php
    ?><button style="margin-left: 10px;" type="button" class="button button-pill button-small preview-entry"><?php echo __('プレビュー') ?></button>

    <script>
    $(function(){
      adminBlog.showEditorTab('#editor-body1');
    });
    </script>

    <?php
    echo $this->Form->end();
    ?>

  </div>
</div>
