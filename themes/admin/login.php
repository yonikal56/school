<form action="" method="post" class="login_form">
    <fieldset>
        <legend>התחברות מנהלים</legend>
        <label for="username">שם משתמש: </label>
        <input type="text" name="username" value="<?= set_value('username') ?>" id="username" class="username_input form-control">
        <label for="password">סיסמא: </label>
        <input type="password" name="password" id="password" class="password_input form-control">
        <input type="submit" name="submit" value="התחבר" class="btn btn-success">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>