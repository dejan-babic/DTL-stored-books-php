<?php

	use DTL\LibraryApp;

	require __DIR__ . '/vendor/autoload.php'; //load vendor (composer) classes
	require_once('modules/DTL/AutoLoader/AutoLoader.class.php'); //enable auto loader (called in LibraryApp)
	require_once('modules/DTL/LibraryApp/LibraryApp.php'); //Enable App

	// Define app constants
	const DC_CONFIG_KEY = 'dtlConfiguration';
	const DC_DTL_DOCUMENT_MANAGER_KEY = 'dtlDocumentManager';
	const DC_CONNECTION_KEY = 'dtlConnection';
	const DC_ODM_CONFIGURATION_KEY = 'odmConfiguration';
	const DC_ODM_ANNOTATION_DRIVER_KEY = 'odmAnnotationDriver';
	const DC_ODM_DOCUMENT_MANAGER_KEY = 'odmDocumentManager';
	const DC_ODM_CONNECTION_KEY = 'odmConnection';

	try {
		LibraryApp::run();
	} catch (Exception $e) {
		print_r($e->getMessage());
	}