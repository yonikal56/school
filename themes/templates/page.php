<?php if(count($page) >= 1): ?>
    <?php if($this->users->if_connected()): ?>
    <?php if($this->users->has_permission($this->users->user['username'], 'manage_pages')): ?>
    <a href="{base}admin/pages/edit/<?= $page['ID'] ?>">עריכת הדף</a>
    <?php endif; ?>
    <?php endif; ?>
    <?php if(isset($full_page)): ?>
    <?php if($full_page): ?>
    <?= get_page_galleries($page['content']) ?>
    <?php else: ?>
        <?= get_page_galleries($page['content']) ?>
    <?php endif; endif; ?>
<?php endif; ?>