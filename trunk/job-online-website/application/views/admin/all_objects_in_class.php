
Total records : <?= count($objects) ?>
<table border="1">
    <thead>
        <?php foreach ($objects as $objID => $fields ) { ?>
        <tr>
            <?php
                foreach ($fields as $field ) {
            ?>
                <th><?= $field['FieldName'] ?></th>
            <?php
            }
            break;
            ?>
        </tr>
        <?php } ?>
    </thead>
    <tbody>
        <?php foreach ($objects as $objID => $fields ) { ?>
        <tr>
            <?php foreach ($fields as $field ) { ?>
                <td><?= $field['FieldValue'] ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
        
    </tbody>
</table>
