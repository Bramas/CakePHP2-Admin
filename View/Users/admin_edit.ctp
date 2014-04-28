<div class="users form">
<?php echo $this->AdminForm->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->AdminForm->input('username');
        echo $this->AdminForm->input('id', array('type' => 'hidden'));
        echo $this->AdminForm->input('new_password', array('type' => 'password'));
        echo $this->AdminForm->input('new_password_confirm', array('type' => 'password'));
        echo $this->AdminForm->input('role_id', array(
        	'label' => 'Role',
            'options' => $Roles
        ));
    ?>
    </fieldset>
<?php echo $this->AdminForm->end(__('Submit')); ?>
</div>