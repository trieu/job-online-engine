
Total records :
<?php 
    $total_records = count($objects);
    echo $total_records;
?>

<?php if($total_records > 0) { ?>
<table border="1">
    <thead>
        <?php foreach ($objects as $objID => $fields ) { ?>
        <tr>
            <th>ID</th>
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
            <td><?= $objID ?></td>
            <?php foreach ($fields as $field ) { ?>
                <td><?= $field['FieldValue'] ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
        
    </tbody>
</table>
 <?php } ?>
