<fieldset>
    <legend>{table}</legend>
</fieldset>
<table class="notices_table table table-condensed table-striped">
    <tr>
        <?php foreach($columns as $column): ?>
        <th><?= $column ?></th>
        <?php endforeach; ?>
        <th>מחיקה</th>
    </tr>
    <?php foreach($archive as $archive_item): ?>
    <tr>
    <?php foreach($archive_item['rows'] as $row): ?>
    <td><?= $row ?></td>
    <?php endforeach; ?>
    <td><a href="{base}admin/archive/delete/<?= $archive_item['ID'] ?>/{page}/{table}">מחיקה</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<div class="pagination">
{pagination}
</div>
<form class="form-group choose-table-form">
    <select class="form-control">
        <?php foreach ($tables as $table_name): ?>
        <option<?= ($table_name == $table ? ' selected' : '') ?>><?= $table_name ?></option>
        <?php endforeach; ?>
    </select>
</form>
<div class="clr" style="margin-bottom: 100px;"></div>