<form action="{base}admin/calender/edit/<?= $event['ID'] ?>/{page}" method="post" class="add_notices_form">
    <fieldset>
        <legend>עריכת אירוע</legend>
        <label for="title">אירוע: </label>
        <input type="text" name="title" value="<?= set_value('title', $event['name']) ?>" id="title" class="title_input form-control">
        <label for="times">קישור משוייך: </label>
        <input type="text" name="times" value="<?= set_value('times', $event['times']) ?>" id="times" class="times_input form-control">
        <input type="submit" name="submit" value="עריכה" class="btn btn-danger btn-add">
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    </fieldset>
</form>