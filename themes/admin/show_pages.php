<table class="notices_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>כותרת</th>
        <th>זמן הוספה</th>
        <th>עריכה</th>
        <th>מחיקה</th>
    </tr>
    <?php foreach ($pages as $page_item): ?>
    <tr>
        <td><?= $page_item['ID'] ?></td>
        <td><?= $page_item['title'] ?></td>
        <td><?= date('d/m/Y', $page_item['time']) ?></td>
        <td><a href="{base}admin/pages/edit/<?= $page_item['ID'] ?>/{page}">עריכה</a></td>
        <td><a href="{base}admin/pages/delete/<?= $page_item['ID'] ?>/{page}">מחיקה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/pages/add" method="post" class="add_pages_form">
    <fieldset>
        <legend>הוספת דף</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title') ?>" id="title" class="title_input form-control">
        <label for="machine_name">כתובת URL אישית: </label>
        <input type="text" name="machine_name" value="<?= set_value('machine_name') ?>" id="machine_name" class="machine_name_input form-control">
        <label for="content">תוכן: </label>
        <textarea name="content"><?= set_value('content') ?></textarea>
        <label for="keywords">מילות מפתח: </label>
        <input type="text" name="keywords" value="<?= set_value('keywords') ?>" id="keywords" class="keywords_input form-control">
        <label for="description">תיאור: </label>
        <textarea name="description" class="form-control"><?= set_value('description') ?></textarea>
        <input type="submit" name="submit" value="הוספה" class="btn btn-success btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>