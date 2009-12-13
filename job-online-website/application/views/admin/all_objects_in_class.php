
<div>
    <h3><?= $objectClass->getObjectClassName()  ?> </h3>
</div>
Display <?= $total_records = count($objects) ?> records

<?php if($total_records > 0) { ?>
<table border="1">
    <thead>       
        <tr>
            <th>ID</th>            
            <?php
            $field_num_vector =  array();
            foreach ($objects as $objID => $fields ) {                
                $field_num_vector[$objID] = count($fields);
            }
            
            function cmp($a,$b){
                if($a > $b){
                    return -1;
                }
                else if($a < $b){
                    return +1;
                }
                return 0;
            }
            uasort($field_num_vector, 'cmp');

            $max_field_num = 0;
            $max_field_key =  key($field_num_vector);
            if($max_field_key != NULL){
                $max_field_num = $field_num_vector[ $max_field_key ];
            }
       
            $fields = $objects[ key($field_num_vector) ];
            foreach ($fields as $field ) {
                echo "<th>". $field['FieldName'] . "</th>";
            }
            ?>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($objects as $objID => $fields ) { ?>
        <tr>
            <td><?= $objID ?></td>
            <?php
                for ($i = 0; $i < $max_field_num ; $i++ ) {
                    if( isset ($fields[ $i ])){
                        echo "<td>". $fields[ $i ]['FieldValue'] ."</td>";
                    }
                    else {
                        echo "<td></td>";
                    }
                }
             ?>
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
