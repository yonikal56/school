<form action="{base}admin/categories/edit/<?= $category['ID'] ?>/{page}" method="post" class="add_categories_form">
    <fieldset>
        <legend>עריכת קטגוריה</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title', $category['title']) ?>" id="title" class="title_input form-control">
        <label for="machine_name">כתובת URL אישית: </label>
        <input type="text" name="machine_name" value="<?= set_value('machine_name', $category['machine_name']) ?>" id="machine_name" class="machine_name_input form-control">
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>