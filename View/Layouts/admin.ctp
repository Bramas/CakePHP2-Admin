<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Admin Dashboard</title>

    <?php echo $this->element('admin_head',array(),array('plugin'=>'Admin')); ?>

  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php

           echo $this->Html->link(Admin::getConfig('admin', 'site-title', 'Titre du Site'),'/',array('class'=>'navbar-brand')); ?>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">
      <?php 
      $user = Admin::currentUser(); 
      echo $user['username']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('Mon profil','/admin/users/edit/'.$this->Session->read('Auth.User.id')); ?></li>
                <li><?php echo $this->Html->link('Déconnexion','/users/logout'); ?></li>
              </ul>
            </li>
            <li><?php echo $this->Html->link('Tableau de bord','/admin'); ?></li>
            <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">
      Utilisateurs <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('Utilisateurs','/admin/users'); ?></li>
                <li><?php echo $this->Html->link('Rôles','/admin/roles'); ?></li>
              </ul>
            </li>
            <li><?php echo $this->Html->link('Settings','/admin/settings'); ?></li>
            <li><a href="#">Help</a></li>
          </ul>
          <!--<form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
        <?php echo $this->element('Admin.extensions_menu'); ?>
        <?php echo $this->element('Admin.menu_tree'); ?>
<!--
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview</a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
          -->
        </div>
        <div id="admin-connexion-status" class="col-sm-8 col-sm-offset-4 col-md-9 col-md-offset-3">

        </div>
        <div id="ajaxPageProgressBar" class="finished col-sm-8 col-sm-offset-4 col-md-9 col-md-offset-3">
          <span style="width: 25%"><span></span></span>
        </div>
        <div class="col-sm-8 col-sm-offset-4 col-md-9 col-md-offset-3 main">


          <div id="layoutContent">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
          </div>


        </div>
      </div>
    </div>

    <div id="dialog-reconnect" class="modal fade" id="reconnect-modal" tabindex="-1" role="dialog" aria-labelledby="Reconnexion" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Se reconnecter</h4>
        </div>
        <!--<form>
        <div class="modal-body">
           <div class="form-group"><label for="formUserUsername">Identifiant</label><input id="formUserUsername" class="form-control" type="text" /></div>
           <div class="form-group"><label for="formUserPassword">Mot de passe</label><input id="formUserPassword" class="form-control" type="password" /></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Se Reconnecter" />
        </div>
        </form>-->
        <div class="users form">
          <?php echo $this->AdminForm->create('User');?>
            <div class="modal-body">
                <?php echo $this->AdminForm->input('username');
                echo $this->AdminForm->input('password');
            ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Se Reconnecter" />
            </div>
            <?php echo $this->AdminForm->end();//__('Se Reconnecter'));?>
        </div>
      </div>
    </div>
  </div>
  </body>
</html>