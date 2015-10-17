<?php

	namespace DTL;

	interface IController {
		public function __construct($dc);
		public function index();
		public function help();
		public function all();
		public function get();
		public function set();
		public function update();
	}