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