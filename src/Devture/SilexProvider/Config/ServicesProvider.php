<?php
namespace Devture\SilexProvider\Config;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Devture\SilexProvider\Config\Loader\JsonFileLoader;

class ServicesProvider implements ServiceProviderInterface {

	public function register(Application $app) {
		$app['devture_config.loader'] = $app->share(function () {
			return new JsonFileLoader();
		});
	}

	public function boot(Application $app) {

	}

}
