<form action="{base}admin/pages/edit/<?= $page_item['ID'] ?>/{page}" method="post" class="edit_pages_form">
    <fieldset>
        <legend>עריכת דף</legend>
        <label for="title">כותרת: </label>
        <input type="text" name="title" value="<?= set_value('title', $page_item['title']) ?>" id="title" class="title_input form-control">
        <label for="machine_name">כתובת URL אישית: </label>
        <input type="text" name="machine_name" value="<?= set_value('machine_name', $page_item['machine_name']) ?>" id="machine_name" class="machine_name_input form-control">
        <label for="content">תוכן: </label>
        <textarea name="content"><?= set_value('content', $page_item['content']) ?></textarea>
        <label for="keywords">מילות מפתח: </label>
        <input type="text" name="keywords" value="<?= set_value('keywords', $page_item['keywords']) ?>" id="keywords" class="keywords_input form-control">
        <label for="description">תיאור: </label>
        <textarea name="description" class="form-control"><?= set_value('description', $page_item['description']) ?></textarea>
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>
<div class="clr" style="margin-bottom: 100px;"></div>