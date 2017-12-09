<form action="{base}admin/menu/edit/<?= $menu['ID'] ?>/{page}" method="post" class="add_notices_form">
    <fieldset>
        <legend>עריכת תפריט</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title', $menu['title']) ?>" id="title" class="title_input form-control">
        <label for="url">URL: </label>
        <input type="text" name="url" value="<?= set_value('url', $menu['url']) ?>" id="url" class="url_input form-control">
        <label for="internal" class="checkbox-inline">קישור חיצוני: </label>
        <input type="checkbox" name="internal" value="1" id="internal" class="internal_input"<?= set_checkbox('internal', '1', ($menu['internal']) == 1) ?>><br><br>
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>