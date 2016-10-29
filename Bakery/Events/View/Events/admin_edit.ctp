<?php 

echo $this->element('Admin.panel_header', array(
	'title'=>'Editer un événement' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Event');

echo $this->AdminForm->input('id', array('type'=>'hidden'));
echo $this->AdminForm->input('title', array('type' => 'text'));
echo $this->AdminForm->input('event_date', array('label' => 'Date', 'type'=>'text', 'class'=>'date-input'));
echo $this->AdminForm->input('event_end', array('label' => 'Date de fin', 'type'=>'text', 'class'=>'date-input'));
echo $this->AdminForm->input('event_time', array('label' => 'Heure', 'type'=>'text'));
echo $this->AdminForm->input('location', array('label' => 'Lieu', 'type'=>'text'));
echo $this->AdminForm->input('price', array('label' => 'Tarif', 'type'=>'text'));
echo $this->AdminForm->editor('content', array('label' => 'Contenu'));


echo $this->AdminForm->submit('Enregistrer');
echo $this->AdminForm->end();

?>
<script type="text/javascript">
	$('.date-input').attr('type', 'date');
</script>