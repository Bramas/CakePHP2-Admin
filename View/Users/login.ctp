<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->AdminForm->create('User');?>
    <fieldset>
        <legend><?php echo __('Merci de rentrer votre nom d\'utilisateur et mot de passe'); ?></legend>
        <?php echo $this->AdminForm->input('username');
        echo $this->AdminForm->input('password');
    ?>
    </fieldset>
<?php echo $this->AdminForm->end(__('Connexion'));?>
</div>