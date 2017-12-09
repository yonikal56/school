<form action="{base}admin/updatePass" method="post" class="add_notices_form">
    <fieldset>
        <legend>שינוי סיסמא</legend>
        <label for="password">סיסמא נוכחית: </label>
        <input type="password" name="password" id="password" class="password_input form-control">
        <label for="newPassword">סיסמא חדשה: </label>
        <input type="password" name="newPassword" id="newPassword" class="newPassword_input form-control">
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
        <?php if(isset($success_message)): ?><div class="alert alert-success">{success_message}</div><?php endif; ?>
    </fieldset>
</form>