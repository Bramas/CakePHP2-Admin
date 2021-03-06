<?php
/*
$extensions = Configure::read('Admin.Extensions');

$menu = array();

foreach($extensions as $name => $config)
{
    if(!empty($config['controller']))
    {
        $controller = $config['controller'];
    }
    else
    {
        $controller = $name;
    }
    
    if(!empty($config['menu']))
    {
        foreach($config['menu'] as $title => $url)
        {
            $menu[$title] = array_merge($url, array('controller' => $controller, 'admin' => true, 'plugin' => false));
        }
    }
}*/
App::uses('Admin', 'Admin.Lib');

$menu = Admin::getAdminMenu();
?>
<ul data-admin-toggle="ajax" class="nav nav-sidebar">
<?php foreach($menu as $title => $url): 
if(!Admin::hasCapability($url['plugin'].'.'.$url['controller'].'.'.(empty($url['require']) ? $url['action'] : $url['require'])))
{
    continue;
}
?>
	<li<?php if($this->Html->url($url) == $this->request->here) echo ' class="active"';?>><?php echo $this->Html->link($title,$url); ?></li>
<?php endforeach; ?>
</ul>

