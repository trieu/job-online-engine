<h1>Change Password</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('welcome/change_password'); ?>
<table>
    <thead>
        <tr>
            <th colspan="2">Required Fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Old Password</td>
            <td><?php echo form_password('old', set_value('old')) ?></td>
        </tr>
        <tr>
            <td>New Password</td>
            <td><?php echo form_password('new', set_value('new')) ?></td>
        </tr>
        <tr>
            <td>Repeat New Password</td>
            <td><?php echo form_password('new_repeat', set_value('new_repeat')) ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Change Password'); ?></td>
        </tr>
    </tfoot>
</table>
<?php echo form_close(); ?>