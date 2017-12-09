<form action="{base}admin/users/edit/<?= $user['ID'] ?>/{page}" method="post" class="add_categories_form">
    <fieldset>
        <legend>עריכת משתמש</legend>
        <label for="permissions[]">הרשאות: </label>
        <select type="text" name="permissions[]" multiple="multiple" id="permissions" class="permissions_input form-control">
            <?php foreach ($permissions as $permission): ?>
            <option value="<?= $permission['value'] ?>" <?= (in_array($permission['value'], $user_permissions) ? 'selected' : '') ?>><?= $permission['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>