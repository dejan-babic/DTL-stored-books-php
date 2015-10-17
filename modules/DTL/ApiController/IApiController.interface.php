<?php

	namespace DTL;

	interface IApiController {
		public function setController($controller);
		public function setAction($action);
		public function setParams(array $params);
		public function run();
	}