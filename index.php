<?php
	session_start();
	require __DIR__ . '/vendor/autoload.php'; //load vendor classes
	require_once('modules/dtlAutoLoader/AutoLoader.class.php'); //enable auto loader

	use DTL\AutoLoader;
	use DTL\FrontController;
	use DTL\MongoDocumentManager;

	const APP_PATH = __DIR__;
	const EXTENSION_SEPARATOR = ',';
	const MODULE_EXTENSIONS = array('.php', '.class.php', '.interface.php');
	const MODULES_PATH = array('modules');
	const MODULES = array('dtlModels' , 'dtlControllers', 'dtlFrontController', 'dtlMongoDocumentManager');

	try {
		AutoLoader::init();
		$frontController = new FrontController();
		$frontController->run();
	} catch (Exception $e) {
		echo json_encode($e->getMessage());
		die;
	}
