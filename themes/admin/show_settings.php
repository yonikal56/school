<form action="{base}admin/settings" method="post" class="add_notices_form">
    <?php foreach($settings as $setting): ?>
    <?php if($this->users->has_permission($this->users->user['username'], 'edit_'.$setting['machine_name'])): ?>
    <label for="<?= $setting['machine_name'] ?>"><?= $setting['name'] ?>: </label>
    <input type="<?= $setting['type'] ?>" name="<?= $setting['machine_name'] ?>" value="<?= set_value($setting['machine_name'], $setting['content']) ?>" id="<?= $setting['machine_name'] ?>" class="<?= $setting['machine_name'] ?>_input form-control">
    <?php endif; ?>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="שמירה" class="btn btn-primary btn-add">
    <div class="alert alert-danger"><?= validation_errors(); ?></div>
    <div class="alert alert-success">{success-message}</div>
</form>