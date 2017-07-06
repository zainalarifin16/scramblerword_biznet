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

		array_push($this->dataWords, new Word("Reading"));
		array_push($this->dataWords, new Word("Speaking"));
		array_push($this->dataWords, new Word("Writing"));
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