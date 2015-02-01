<div class="box">
  <header>
    <h1><?php echo __('コメント一覧') ?></h1>
  </header>
  <div class="inner">

    <?php
    echo $this->Form->create('Comment', array(
      'type' => 'get',
      'class' => 'form-01',
    ));
    ?>
    <div class="filter">
      <table>
        <tr>
          <th><?php echo __('コメント') ?></th>
          <td><?php
            echo $this->Form->input('body', array(
              'label' => FALSE,
              'type' => 'text',
            ));
          ?></td>
          <th><?php echo __('ブログ') ?></th>
          <td><?php
            echo $this->Form->input('page_id', array(
              'label' => FALSE,
              'empty' => TRUE,
              'options' => $pageIds,
            ));
          ?></td>
          <th><?php echo __('エントリ ID') ?></th>
          <td><?php
            echo $this->Form->input('entry_id', array(
              'label' => FALSE,
              'type' => 'text',
            ));
          ?></td>
          <th><?php echo __('未承認') ?></th>
          <td><?php
            echo $this->Form->input('noapproved', array(
              'label' => FALSE,
              'type' => 'checkbox',
            ));
          ?></td>
          <td><button type="submit" class="button button-primary button-small button-pill">検索</button></td>
        </tr>
      </table>
    </div>

    <?php
    echo $this->Form->end();
    ?>

    <div class="spacer2"></div>

    <?php
    echo $this->element('Baked/paginator_main');
    ?>
    <div class="spacer2"></div>

    <?php
    $url = '/admin/blog/comments/listing';
    if (!empty($this->data['Comment'])) $url .= '?'.http_build_query($this->data['Comment']);
    echo $this->Form->create('Comment', array(
      'url' => $url,
      'class' => 'form-01',
    ));
    echo $this->Baked->hiddenToken();
    ?>

    <table class="table-01 full">
      <thead>
        <tr>
          <th></th>
          <th><?php echo __('投稿者') ?></th>
          <th><?php echo __('エントリ') ?></th>
          <th style="width: 40%;"><?php echo __('コメント') ?></th>
          <th><?php echo __('承認') ?></th>
          <th><?php echo __('投稿日時') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($comments as $comment) : ?>
          <tr>
            <td>
              <input type="checkbox" name="data[Comment][id][]" value="<?php echo $comment['Comment']['id'] ?>" />
            </td>
            <td><?php echo h($comment['Comment']['name']) ?></td>
            <td><a href="<?php echo h($comment['Comment']['entry_path']) ?>"><?php echo h(mb_strimwidth($comment['Entry']['title'], 0, 30, '..', 'utf8')) ?></a></td>
            <td><?php echo nl2br(h(mb_strimwidth($comment['Comment']['body'], 0, 300, '..', 'utf8'))) ?></td>
            <td class="center">
              <?php if ($comment['Comment']['approved']) : ?>
                <?php echo Comment::$APPROVED[$comment['Comment']['approved']] ?>
              <?php else : ?>
                <em class="em-01"><?php echo Comment::$APPROVED[$comment['Comment']['approved']] ?></em>
              <?php endif ; ?>
            </td>
            <td><?php echo Baked::dateFormat($comment['Comment']['created'], 'Y/m/d H:i') ?></td>
        <?php endforeach ; ?>
      </tbody>
    </table>

    <div class="spacer2"></div>

    <?php
    echo $this->Form->input('mode', array(
      'label' => __('選択したコメントを'),
      'options' => array(
        'approve' => __('承認する'),
        'unapprove' => __('未承認にする'),
        'delete' => __('削除する'),
      ),
      'div' => FALSE,
      'empty' => TRUE,
    ));
    ?>

    <button type="submit" style="margin-left: 10px;" class="button button-primary button-pill button-tiny"><?php echo __('実行') ?></button>

    <?php
    echo $this->Form->end();
    ?>

    <div class="spacer2"></div>

    <?php
    echo $this->element('Baked/paginator_numbers');
    ?>

  </div>
</div>

