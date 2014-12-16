<?php

echo $this->AdminForm->create('Page');

echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('parent_id', array('type' => 'hidden'));

$currentRevision = '';
$disapprovRevision = '';
if(!empty($Revisions) && count($Revisions)){
	$currentRevision = 'écrit par '.$Revisions[0]['User']['username'];
	if($Revisions[0]['Page']['status'] == 'pending'){
		$currentRevision .= ' - en attente de validation';
		if(Admin::hasCapability('pages.publish'))
		{
			$disapprovRevision = $this->Html->link(' - ne pas valider et revenir à la version précédente', array(
					'controller' => 'pages',
					'action'     => 'disapprove',
					$this->request->data['Page']['id']
					));
		}
	}
	//$currentRevision = $this->Html->link($currentRevision, '#');
}
echo $this->AdminForm->editor('content', array('label' => 'Contenu '.$currentRevision.$disapprovRevision));


if(Admin::hasCapability('pages.publish'))
{
	echo $this->AdminForm->submit('Publier');
}
else
{
	echo $this->AdminForm->submit('Soumettre à Validation');
}
