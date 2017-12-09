<table class="uploads_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>קובץ</th>
        <th>זמן הוספה</th>
        <th>מעלה</th>
        <th>מחיקה</th>
    </tr>
    <?php foreach ($uploads as $file): ?>
    <tr class="open_from_to" data-id="<?= $file['ID'] ?>">
        <td><?= $file['ID'] ?></td>
        <td><?= $file['name'] ?></td>
        <td><?= date('d/m/Y', $file['time']) ?></td>
        <td><?= $file['username'] ?></td>
        <td><a href="{base}admin/uploads/delete/<?= $file['ID'] ?>/{page}">מחיקה</a></td>
    </tr>
    <tr class="from_to_desc" data-id="<?= $file['ID'] ?>">
        <td colspan="5">קישור חיצוני - <a target="_blank" href="{base}uploads/<?= $file['name'] ?>">{base}uploads/<?= $file['name'] ?></a><br>
        קישור פינימי - <a target="_blank" href="{base}uploads/<?= $file['name'] ?>">uploads/<?= $file['name'] ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
<form action="{base}admin/uploads/{page}" method="post" class="uploader_form" enctype="multipart/form-data">
    <fieldset>
        <legend>העלאת קבצים</legend>
        <div class="input-group">
            <label class="input-group-btn">
                <span class="btn btn-primary">
                    בחר קבצים <input class="files_input" type="file" name="files[]" style="display: none;" multiple>
                </span>
            </label>
            <input type="text" class="form-control" readonly>
        </div>
        <input type="submit" name="submit" value="העלאה" class="btn btn-success btn-add">
        <div class="alert alert-danger">{errors}<p>{error}</p>{/errors}</div>
        <div class="alert alert-success">{success-message}</div>
    </fieldset>
</form>
<div class="pagination">
{pagination}
</div>
<div class="clr" style="margin-bottom: 100px;"></div>