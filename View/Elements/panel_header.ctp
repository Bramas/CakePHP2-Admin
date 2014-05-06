<?php
/**
*	addNew is an array containing label, url and options for the link used to create 
*	a new item
*/

Configure::write('Admin.variables.panel_header', 'TESTTTTT');

$addNew;

if(empty($addNew['options']))
{
	$addNew['options'] = array();
}
if(empty($addNew['options']['class']))
{
	$addNew['options']['class'] = '';
}

$addNew['options']['class'] .= ' btn btn-default btn-sm';

/**
*	backUrl is the url for the back button (optional)
*/

/**
*	title is used for the title of the panel
*/
?>
<h1 class="admin-panel-header">
<?php if(!empty($backUrl)) echo $this->Html->link(
'',
$backUrl,
array('class' => 'btn btn-default glyphicon glyphicon-arrow-left')); ?>
 
<?php echo $title ?><?php 
if(!empty($addNew['url']))
{
	echo  ' <small>'.$this->Html->link($addNew['label'], $addNew['url'], $addNew['options']).'</small>';
}
?><?php 
if(!empty($submit))
{
	echo ' '.$this->AdminForm->submit($submit);
}
?></h1>