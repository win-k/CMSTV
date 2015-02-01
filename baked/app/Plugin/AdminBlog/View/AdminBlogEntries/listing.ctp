<div class="box">
  <header>
    <h1><?php echo __('「%s (%s)」の記事一覧', $page['Page']['title'], $page['Page']['path']) ?></h1>
  </header>
  <div class="inner">
    <?php
    echo $this->element('Baked/paginator_main');
    ?>
    <div class="spacer2"></div>

    <?php
    $url = CURRENT_URL;
    if (!empty($this->data['Entry'])) $url .= '?'.http_build_query($this->data['Entry']);
    echo $this->Form->create('Entry', array(
      'url' => $url,
      'class' => 'form-01',
    ));
    echo $this->Baked->hiddenToken();
    ?>

    <table class="table-01 full">
      <thead>
        <tr>
          <th></th>
          <th>ID</th>
          <th><?php echo __('タイトル') ?></th>
          <th><?php echo __('作者') ?></th>
          <th><?php echo __('コメント数 (未承認)') ?></th>
          <th><?php echo __('公開日時') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($entries as $entry) : ?>
          <tr>
            <td>
              <input type="checkbox" name="data[Entry][id][]" value="<?php echo $entry['Entry']['id'] ?>" />
            </td>
            <td><?php echo $entry['Entry']['id'] ?></td>
            <td><a href="<?php echo URL ?>admin/blog/entries/add/<?php echo $entry['Entry']['id'] ?>"><?php echo h($entry['Entry']['title']) ?></a></td>
            <td><?php echo h($entry['Staff']['name']) ?></td>
            <td class="center"><a href="<?php echo URL ?>admin/blog/comments/listing?page_id=<?php echo $page['Page']['id'] ?>&entry_id=<?php echo $entry['Entry']['id'] ?>"><?php echo number_format($entry['Entry']['comments_count']) ?></a> (<a href="<?php echo URL ?>admin/blog/comments/listing?page_id=<?php echo $page['Page']['id'] ?>&entry_id=<?php echo $entry['Entry']['id'] ?>&noapproved=1"><?php echo number_format($entry['Entry']['unapproved_comments_count']) ?></a>)</td>
            <td><?php echo Baked::dateFormat($entry['Entry']['published'], 'Y/m/d H:i') ?></td>
          </tr>
        <?php endforeach ; ?>
      </tbody>
    </table>

    <div class="spacer2"></div>

    <?php
    echo $this->Form->input('mode', array(
      'label' => __('選択したエントリを'),
      'empty' => TRUE,
      'options' => array(
        'delete' => __('削除する'),
      ),
      'div' => FALSE,
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

    <ul class="icon-links">
      <li><a href="<?php echo URL ?>admin/blog/entries/add?page_id=<?php echo $page['Page']['id'] ?>"><i class="icon-pencil"></i><?php echo __('新規記事') ?></a></li>
    </ul>

  </div>

</div>

