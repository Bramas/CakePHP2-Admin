<?php

App::uses('Admin', 'Admin.Lib');

class AdminController extends AdminAppController {

    public $adminCapabilities = array(
            'index' => 'Se connecter à l\'administration',
        );

    public function admin_index() {


        /*$plugins = Admin::getModels();
        $counts = array();

        // Gather record counts
        foreach ($plugins as $plugin) {
            foreach ($plugin['models'] as $model) {
                if ($model['installed']) {
                    $object = Admin::introspectModel($model['class']);

                    if ($object->hasMethod('getCount')) {
                        $count = $object->getCount();
                    } else {
                        $count = $object->find('count', array(
                            'cache' => array($model['class'], 'count'),
                            'cacheExpires' => '+24 hours'
                        ));
                    }

                    $counts[$model['class']] = $count;
                }
            }
        }*/
    }

}
