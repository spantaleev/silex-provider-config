<?php
namespace Devture\SilexProvider\Config\Loader;

use Devture\SilexProvider\Config\Exception;

class JsonFileLoader {

	public function load(array $configFiles, array $parameterFiles) {
		$config = array();
		foreach ($configFiles as $filePath) {
			$config = array_replace($config, $this->loadFile($filePath));
		}

		$parameters = array();
		foreach ($parameterFiles as $parametersOrPath) {
			if (is_string($parametersOrPath)) {
				$parametersOrPath = $this->loadFile($parametersOrPath);
			}
			$parameters = array_replace($parameters, $parametersOrPath);
		}

		return $this->replaceParameters($config, $parameters);
	}

	private function loadFile($path) {
		if (!file_exists($path)) {
			throw new Exception('Cannot load file: ' . $path);
		}
		$config = json_decode(file_get_contents($path), 1);
		if ($config === null) {
			throw new Exception('Cannot decode file contents: ' . $path);
		}
		return $config;
	}

	private function replaceParameters(array $config, array $parameters) {
		foreach ($config as $key => $value) {
			if (is_array($value)) {
				$config[$key] = $this->replaceParameters($value, $parameters);
			} else if (is_string($value) && strpos($value, '%') === 0) {
				$parameterKey = substr($value, 1, strlen($value) - 2);
				if (!array_key_exists($parameterKey, $parameters)) {
					throw new Exception('Undefined parameter ' . $parameterKey . ' -- `' . $value . '`');
				}
				$config[$key] = $parameters[$parameterKey];
			}
		}
		return $config;
	}

}
