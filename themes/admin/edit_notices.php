<form action="{base}admin/notices/edit/<?= $notice['ID'] ?>/{page}" method="post" class="add_notices_form">
    <fieldset>
        <legend>עריכת עדכון</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title', $notice['title']) ?>" id="title" class="title_input form-control">
        <label for="document">קישור משוייך: </label>
        <input type="text" name="document" value="<?= set_value('document', $notice['document']) ?>" id="document" class="document_input form-control">
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>