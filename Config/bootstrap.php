<?php

Configure::write('Extensions',array(
                                        'pages'=>array(
                                            'modelName'=>'Page',
                                            'views'=>array(
                                                'display'=>array(
                                                    'name'=>"Affichage d'une page simple",
                                                    'mainIcon'=>'/HappyCms/img/paper_content.png',
                                                    'menuIcon'=>array(
                                                            'image'=>'/HappyCms/img/skin.png',
                                                            'position'=>'0px -180px'
                                                        )
                                                    )
                                            )
                                        )
                                        ));

Configure::write('Routing.prefixes', array('admin'));


if(!function_exists('texte_resume_brut'))
{
	function texte_resume_brut($texte, $nbreCar)
	{
		$texte 				= trim(strip_tags($texte));
		if(is_numeric($nbreCar))
		{
			$PointSuspension	= '...';
			$texte			.= ' ';
			$LongueurAvant		= strlen($texte);
			if ($LongueurAvant > $nbreCar) {
				$texte = substr($texte, 0, strpos($texte, ' ', $nbreCar));
				if ($PointSuspension!='') {
					$texte	.= $PointSuspension;
				}
			}
		}
		return $texte;
	};
}


Cache::config('admin_menus', array('engine' => 'File', 'groups'=>array('admin_menus')));

Cache::config('admin_config', array('engine' => 'File', 'groups'=>array('admin_config')));

