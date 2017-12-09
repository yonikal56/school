<?php foreach($links as $link): ?>
    <?php if(!empty($link['image'])): ?>
        <div class="row">
            <div class="col-md-12">
              <a href="<?= $link['url'] ?>" target="_blank" class="thumbnail">
                <img src="<?= $link['image'] ?>" alt="<?= $link['title'] ?>">
                <div class="caption">
                    <p><?= $link['title'] ?></p>
                </div>
              </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-12">
              <a href="<?= $link['url'] ?>" target="_blank" class="thumbnail">
                <div class="caption">
                    <p><?= $link['title'] ?></p>
                </div>
              </a>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
