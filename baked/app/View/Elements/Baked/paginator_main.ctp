<div class="bk-info">
  <div class="bk-info-left">
    <?php
    $txt = '全 <b>{:count}</b> 件, <b>{:page}</b> / <b>{:pages}</b> ページ, <b>{:start}</b> ～ <b>{:end}</b> 件を表示中';
    if (!empty($paginatePrefix)) {
      $txt = $paginatePrefix . $txt;
    }
    echo $this->Paginator->counter($txt);
    ?>
  </div>
  <div class="bk-info-right">
    <?php
    echo $this->Paginator->numbers(array(
      'separator' => '',
    ));
    ?>
  </div>
</div>
