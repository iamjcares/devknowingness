<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {


	public function setUp()
	{
		parent::setUp();
		Session::start();
		$setting = Setting::first();
		include(__DIR__.'/../public/content/themes/'. $setting->theme . '/functions.php');
		View::addNamespace('Theme', __DIR__.'/../public/content/'. $setting->theme . '/default');
	}

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

}
