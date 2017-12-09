<div class="panel panel-default">
  <div class="panel-heading widgets-title">הודעות בית ספר</div>
  <div class="panel-body notices">
    <?php foreach ($notices as $notice): ?>
    <div class="notice_item">
    <?php if(!empty($notice['document'])): ?>
        <a href="<?= $notice['document'] ?>"><?= $notice['title'] ?></a>
    <?php else: ?>
        <?= $notice['title'] ?>
    <?php endif; ?>
    <p class="notice-date"><?= date('d/m/Y G:i', $notice['time']) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</div>