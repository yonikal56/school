<table class="notices_table table table-condensed table-striped">
    <tr>
        <th>ID</th>
        <th>משתמש</th>
        <th>מה השתנה</th>
        <th>זמן שינוי</th>
        <th>מחיקה</th>
    </tr>
    <?php foreach($follow as $follow_item): ?>
    <tr class="open_from_to" data-id="<?= $follow_item['ID'] ?>">
        <td><?= $follow_item['ID'] ?></td>
        <td><?= $follow_item['username'] ?></td>
        <td><?= $follow_item['changed'] ?></td>
        <td><?= date('d/m/Y G:i:s', $follow_item['time']) ?></td>
        <td><a href="{base}admin/folllow/delete/<?= $follow_item['ID'] ?>/{page}">מחיקה</a></td>
    </tr>
    <tr class="from_to_desc" data-id="<?= $follow_item['ID'] ?>">
        <td colspan="5"><?= $follow_item['from'] . '->' . $follow_item['to'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<div class="pagination">
{pagination}
</div>