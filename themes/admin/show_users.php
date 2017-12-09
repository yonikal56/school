<table class="notices_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>שם משתמש</th>
        <th>עריכה</th>
        <th>מחיקה</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['ID'] ?></td>
        <td><?= $user['username'] ?></td>
        <td><a href="{base}admin/users/edit/<?= $user['ID'] ?>/{page}">עריכה</a></td>
        <td><a href="{base}admin/users/delete/<?= $user['ID'] ?>/{page}">מחיקה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/users/add" method="post" class="add_categories_form">
    <fieldset>
        <legend>הוספת משתמש</legend>
        <label for="username">שם משתמש: </label>
        <input type="text" name="username" value="<?= set_value('username') ?>" id="username" class="username_input form-control">
        <label for="password">סיסמא: </label>
        <input type="password" name="password" value="<?= set_value('password') ?>" id="password" class="password_input form-control">
        <input type="submit" name="submit" value="הוספה" class="btn btn-success btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>