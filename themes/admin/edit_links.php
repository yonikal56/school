<form action="{base}admin/links/edit/<?= $link['ID'] ?>/{page}" method="post" class="add_notices_form">
    <fieldset>
        <legend>עריכת לינק</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title', $link['title']) ?>" id="title" class="title_input form-control">
        <label for="url">קישור משוייך: </label>
        <input type="text" name="url" value="<?= set_value('url', $link['url']) ?>" id="url" class="url_input form-control">
        <label for="image">תמונה: </label>
        <input type="text" name="image" value="<?= set_value('image', $link['image']) ?>" id="image" class="image_input form-control">
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>