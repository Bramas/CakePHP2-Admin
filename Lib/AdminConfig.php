<?php


class AdminConfig {

	public static function read($group)
	{
		return Cache::remember('admin_config_'.$group, function() use($group) {
			$o = new CakeObject();
			return $o->requestAction('/config/get/'.$group);
		}, 'admin_config');
	}
}
