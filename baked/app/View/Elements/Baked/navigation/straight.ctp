<ul>
  <?php foreach ($menuList as $menu) : ?>
    <?php
    $classes = array();
    if ($menu['current']) $classes[] = 'current';
    ?>
    <li class="<?php echo implode(' ', $classes) ?>">
      <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
      <?php if ($menu['current'] == TRUE && !empty($menu['sub'])) : ?>
        <ul>
          <?php foreach ($menu['sub'] as $menu) : ?>
            <?php
            $classes = array();
            if ($menu['current']) $classes[] = 'current';
            ?>
            <li class="<?php echo implode(' ', $classes) ?>">
              <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
              <?php if ($menu['current'] == TRUE && !empty($menu['sub'])) : ?>
                <ul>
                  <?php foreach ($menu['sub'] as $menu) : ?>
                    <?php
                    $classes = array();
                    if ($menu['current']) $classes[] = 'current';
                    ?>
                    <li class="<?php echo implode(' ', $classes) ?>">
                      <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
                    </li>
                  <?php endforeach ; ?>
                </ul>
              <?php endif ; ?>
            </li>
          <?php endforeach ; ?>
        </ul>
      <?php endif ; ?>
    </li>
  <?php endforeach ; ?>
</ul>
