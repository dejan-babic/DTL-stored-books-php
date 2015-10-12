<?php

	namespace DTL;

	use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

	/**
	 * Class Book
	 * @package DTL
	 * @ODM\Document
	 */
	class Book {

		/** @ODM\Id */
		private $id;
		/** @ODM\String */
		private $title;
		/** @ODM\Collection */
		private $authors = array();
		/** @ODM\String */
		private $publishedDate;
		/** @ODM\Int */
		private $pageCount;
		/** @ODM\String */
		private $printType;
		/** @ODM\Collection */
		private $categories = array();
		/** @ODM\String */
		private $thumbnail;
		/** @ODM\String */
		private $language;
		/** @ODM\String */
		private $link;

		/**
		 * Book constructor.
		 * @param $id
		 * @param $title
		 * @param array $authors
		 */
		public function __construct ($title, array $authors) {
			$this->title   = $title;
			$this->authors = $authors;
		}

	}