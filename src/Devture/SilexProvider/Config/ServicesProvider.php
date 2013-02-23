<?php
namespace Devture\SilexProvider\Config;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ServicesProvider implements ServiceProviderInterface {

	public function register(Application $app) {
		$app['devture_config.loader'] = $app->share(function () {
			return new Loader\JsonFileLoader();
		});
	}

	public function boot(Application $app) {

	}

}
