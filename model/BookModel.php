<?php
/**
* Book Model
*/
include_once("model/Word.php");
class BookModel
{
	public $dataWords = array();

	function __construct()
	{
		$this->initWords();
	}

	public function initWords(){
		$db = Db::getInstance();
		array_push($this->dataWords, new Word(1, "Reading"));
		array_push($this->dataWords, new Word(2, "Speaking"));
		array_push($this->dataWords, new Word(3, "Writing"));
		return $this->dataWords;

	}

	public function addWords($word){
		array_push($this->dataWords, new Word($word));
		return $this->dataWords;
	}

	public function getWords(){
		return $this->dataWords;
	}

}
?>