<?php
namespace Devture\SilexProvider\Config;

class ServicesProvider implements \Pimple\ServiceProviderInterface {

	public function register(\Pimple\Container $container) {
		$container['devture_config.loader'] = function () {
			return new Loader\JsonFileLoader();
		};
	}

}
