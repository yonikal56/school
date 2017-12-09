<table class="notices_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>אירוע</th>
        <th>תאריכים</th>
        <th>עריכה</th>
        <th>מחיקה</th>
    </tr>
    <?php foreach ($calender as $event): ?>
    <tr>
        <td><?= $event['ID'] ?></td>
        <td><?= $event['name'] ?></td>
        <td><?= $event['times'] ?></td>
        <td><a href="{base}admin/calender/edit/<?= $event['ID'] ?>/{page}">עריכה</a></td>
        <td><a href="{base}admin/calender/delete/<?= $event['ID'] ?>/{page}">מחיקה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/calender/add" method="post" class="add_notices_form">
    <fieldset>
        <legend>הוספת אירוע</legend>
        <label for="title">אירוע: </label>
        <input type="text" name="title" value="<?= set_value('title') ?>" id="title" class="title_input form-control">
        <label for="times">תאריכים: </label>
        <input type="text" name="times" value="<?= set_value('times') ?>" id="times" class="times_input form-control">
        <input type="submit" name="submit" value="הוספה" class="btn btn-success btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>