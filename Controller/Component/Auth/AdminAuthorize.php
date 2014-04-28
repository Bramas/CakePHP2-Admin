<?php

App::uses('Admin', 'Admin.Lib');

App::uses('BaseAuthorize', 'Controller/Component/Auth');

class AdminAuthorize extends BaseAuthorize {
	public function authorize($user, CakeRequest $request) {

		if(Admin::hasCapability($user, $request->params))
		{
			return true;
		}
		debug('Impossible d\'accéder à '.Admin::arrayToCapability($request->params));
		//exit();
		return false;
	}
}