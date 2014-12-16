<div class="users form">
<?php echo $this->AdminForm->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Editer un Utilisateur'); ?></legend>
        <?php echo $this->AdminForm->input('username',array('label' => 'Identifiant'));
        echo $this->AdminForm->input('id', array('type' => 'hidden'));
        echo $this->AdminForm->input('new_password', array('type' => 'password', 'label' => 'Mot de passe'));
        echo $this->AdminForm->input('new_password_confirm', array('type' => 'password', 'label' => 'Mot de passe (confirmation)'));
        echo $this->AdminForm->input('role_id', array(
        	'label' => 'Rôle',
            'options' => $Roles
        ));
    ?>
    </fieldset>
<?php echo $this->AdminForm->end(__('Submit')); ?>
</div>