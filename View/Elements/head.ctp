<?php
//$cdn = 1;
if(isset($cdn))
{
	echo $this->Html->css('bootstrap.min.css');
	echo $this->Html->css('bootstrap-theme.min.css');
	echo $this->Html->script('jquery-2.1.0.min.js');
	echo $this->Html->script('bootstrap.min.js');
	echo $this->Html->script('tinymce/tinymce.min.js');	
	echo $this->Html->css('font-awesome.css');
}
else
{
	echo $this->Html->script('//code.jquery.com/jquery-2.1.0.min.js');
	echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
	echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css');
	echo $this->Html->script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js');
	echo $this->Html->script('//tinymce.cachefly.net/4.0/tinymce.min.js');
	echo $this->Html->css('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
}

echo $this->Html->script('Admin.admin.js');


echo $this->Html->script('Admin.jstree.min.js');
echo $this->Html->css('Admin.jstree-themes/default/style.css');



echo $this->Html->css('Admin.dashboard.css');

?>
<script type="text/javascript">
	var AdminBaseUrl = '<?php echo $this->Html->url('/admin/'); ?>';
	var BaseUrl = '<?php echo $this->Html->url('/'); ?>';
	var AdminFirstUrl = '<?php echo $this->request->here; ?>';
</script>