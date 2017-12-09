<table class="links_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>כותרת</th>
        <th>סדר</th>
        <th>עריכה</th>
        <th>מחיקה</th>
        <th>למעלה</th>
        <th>למטה</th>
    </tr>
    <?php foreach ($links as $link): ?>
    <tr>
        <td><?= $link['ID'] ?></td>
        <td><?= $link['title'] ?></td>
        <td><?= $link['order'] ?></td>
        <td><a href="{base}admin/links/edit/<?= $link['ID'] ?>/{page}">עריכה</a></td>
        <td><a href="{base}admin/links/delete/<?= $link['ID'] ?>/{page}">מחיקה</a></td>
        <td><a href="{base}admin/links/up/<?= $link['ID'] ?>/{page}">למעלה</a></td>
        <td><a href="{base}admin/links/down/<?= $link['ID'] ?>/{page}">למטה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/links/add/{position}" method="post" class="add_links_form">
    <fieldset>
        <legend>הוספת לינק</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title') ?>" id="title" class="title_input form-control">
        <label for="url">קישור משוייך: </label>
        <input type="text" name="url" value="<?= set_value('url') ?>" id="url" class="url_input form-control">
        <label for="image">תמונה: </label>
        <input type="text" name="image" value="<?= set_value('image') ?>" id="image" class="image_input form-control">
        <input type="submit" name="submit" value="הוספה" class="btn btn-success btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>