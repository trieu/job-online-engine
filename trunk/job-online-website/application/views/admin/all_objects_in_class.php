
Total records :
<?php 
    $total_records = count($objects);
    echo $total_records;
?>

<?php if($total_records > 0) { ?>
<table border="1">
    <thead>       
        <tr>
            <th>ID</th>            
            <?php
             foreach ($objects as $objID => $fields ) {
                foreach ($fields as $field ) {
            ?>
                <th><?= $field['FieldName'] ?></th>
            <?php
                }
                break;
             }
            ?>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($objects as $objID => $fields ) { ?>
        <tr>
            <td><?= $objID ?></td>
            <?php foreach ($fields as $field ) { ?>
                <td><?= $field['FieldValue'] ?></td>
            <?php } ?>
            <td>
                <div>                    
                    <?= anchor('admin/object_controller/edit/'.$objID , 'Edit', array('title' => 'Edit')) ?>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
 <?php } ?>
