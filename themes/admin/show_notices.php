<table class="notices_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>כותרת</th>
        <th>זמן הוספה</th>
        <th>עריכה</th>
        <th>מחיקה</th>
    </tr>
    <?php foreach ($notices as $notice): ?>
    <tr>
        <td><?= $notice['ID'] ?></td>
        <td><?= $notice['title'] ?></td>
        <td><?= date('d/m/Y', $notice['time']) ?></td>
        <td><a href="{base}admin/notices/edit/<?= $notice['ID'] ?>/{page}">עריכה</a></td>
        <td><a href="{base}admin/notices/delete/<?= $notice['ID'] ?>/{page}">מחיקה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/notices/add" method="post" class="add_notices_form">
    <fieldset>
        <legend>הוספת עדכון</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title') ?>" id="title" class="title_input form-control">
        <label for="document">קישור משוייך: </label>
        <input type="text" name="document" value="<?= set_value('document') ?>" id="document" class="document_input form-control">
        <input type="submit" name="submit" value="הוספה" class="btn btn-success btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>