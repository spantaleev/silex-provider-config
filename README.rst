Silex Config Provider
=====================

A configuration provider for the `Silex <http://silex.sensiolabs.org/>`_ micro-framework.

Usage
-----

The configuration loader uses the concept of *configuration* files (containing the configuration skeleton)
and *parameter* files (variables that customize the configuration).

Moving some configuration values outside of the config skeleton allows config files
to be commited to version control and remain identical everywhere, while leaving certain "parameters"
up for customization.

Example configuration::

	//config.json
	{
		"key": "value",
		"something": "%something%",
		"websites": {
			"first": "%main_website%",
			"second": "%another_website%"
		}
	}

	//parameters.json
	{
		"something": "value for something",
		"main_website": "http://devture.com/",
		"another_website": "http://github.com/spantaleev"
	}


Usage::

	<?php
	$app->register(new \Devture\SilexProvider\Config\ServicesProvider());

	$configFiles = array('/path/to/config.json');
	$parameterFiles = array('/path/to/parameters.json');

	$app['config'] = $app['devture_config.loader']->load($configFiles, $parameterFiles);


Result::

	$app['config'] = array(
		'key' => 'value',
		'something' => 'value for something',
		'websites' => array(
			'first' => 'http://devture.com/',
			'second' => 'http://github.com/spantaleev',
		)
	);


Limitations
------------

* Only JSON config files are supported (intentional)
* Partial parameter replacements are not supported (`"storage_path": "%base_path%/storage"`) - may be implemented later
