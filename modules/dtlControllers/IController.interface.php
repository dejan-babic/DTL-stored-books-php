<?php

	namespace DTL;

	interface IController {
		public function index();
		public function help();
		public function all();
		public function get();
		public function set();
		public function update();
	}