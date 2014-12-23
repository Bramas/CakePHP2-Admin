<?php
$this->start('title');
echo 'Actualités';
$this->end();
?><div class="posts">
<?php 
$controller = 'posts';

App::uses('AdminConfig', 'Admin.Lib');
$config = AdminConfig::read('posts');
if(!empty($config['parent_menu']))
{
	$controller = $config['parent_menu'];
}	

foreach($Posts as $Post):
$Post = $Post['Post'];
?>

<div class="posts-item">
<a href="<?php echo $this->Html->url(array(
	'controller' => $controller,
	'action' => 'view',
	$Post['id'].'-'.Inflector::slug($Post['title'],'-'))); ?>">
	<h1 class="title">
		<?php echo $Post['title']; ?>
	</h1>
	<div class="image">
		<?php
		
		if(empty($Post['featured_image']))
		{
			echo $this->Html->image(Configure::read('Admin.StaticDomain').'/files/partners/default.png'.'_100x100', array('height' => '100','width' => '100'));
		}
		else
		{
			echo $this->Html->image(Configure::read('Admin.StaticDomain').$Post['featured_image'].'_100x100', array('height' => '100','width' => '100'));
		} ?>
		
	</div>
	<p class="resume">
		<?php echo texte_resume_brut($Post['content'], 150); ?>
	</p>
</a>
</div>
<?php
endforeach;
?>
</div>
<?php
echo $this->Paginator->numbers();
?>