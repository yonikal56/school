<table class="notices_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>כותרת</th>
        <th>סדר</th>
        <th>עריכה</th>
        <th>מחיקה</th>
        <th>למעלה</th>
        <th>למטה</th>
    </tr>
    <?php foreach ($categories as $category): ?>
    <tr>
        <td><?= $category['ID'] ?></td>
        <td><?= $category['title'] ?></td>
        <td><?= $category['order'] ?></td>
        <td><a href="{base}admin/categories/edit/<?= $category['ID'] ?>/{page}">עריכה</a></td>
        <td><a href="{base}admin/categories/delete/<?= $category['ID'] ?>/{page}">מחיקה</a></td>
        <td><a href="{base}admin/categories/up/<?= $category['ID'] ?>/{page}">למעלה</a></td>
        <td><a href="{base}admin/categories/down/<?= $category['ID'] ?>/{page}">למטה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/categories/add" method="post" class="add_categories_form">
    <fieldset>
        <legend>הוספת עדכון</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title') ?>" id="title" class="title_input form-control">
        <label for="machine_name">כתובת URL אישית: </label>
        <input type="text" name="machine_name" value="<?= set_value('machine_name') ?>" id="machine_name" class="machine_name_input form-control">
        <input type="submit" name="submit" value="הוספה" class="btn btn-success btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>