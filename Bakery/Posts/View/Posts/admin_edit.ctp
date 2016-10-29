<?php 

echo $this->element('Admin.panel_header', array(
	'title'=>'Editer une actualité' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Post');

echo $this->AdminForm->input('id', array('type'=>'hidden'));
echo $this->AdminForm->input('title', array('type' => 'text'));
echo $this->AdminForm->input('created', array('type' => 'text', 'label' => 'Date de l\'actualité', 'class'=>'input-datetime-local'));
echo $this->AdminForm->editor('content', array('label' => 'Contenu'));

$this->Upload->setFormHelper($this->AdminForm);
$this->Upload->setModel('Post');
echo $this->Upload->input('featured_image', array('type' => 'file', 'label'=>'Image'));


echo $this->AdminForm->submit('Enregistrer');
echo $this->AdminForm->end();
?>
<script type="text/javascript">
	$('.input-datetime-local').attr('type', 'datetime-local');
</script>