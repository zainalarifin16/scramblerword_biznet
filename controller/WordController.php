<?php
/**
* Class Controller
*/

include_once("model/BookModel.php");

class WordController
{

	private $book_model;

	function __construct()
	{
		$this->book_model = new BookModel;
	}

	public function index(){
		$wordChallange = array();
		
		$wordChallange = $this->create_question($this->book_model);

		$array_respon = array(
						"data" => $wordChallange
						);
		header('Content-Type: application/json');
		echo json_encode($array_respon);
	}

	//post
	public function answerQuestion()
	{
		$data = $_POST;
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	//get
	public function addWord($word){
		if($word != null){
			$this->book_model->addWords($word);
			$array_data = array(
							"data" => $this->book_model
							);
			header('Content-Type: application/json');
			echo json_encode($array_data);
		}
	}

	public function getAll(){

		$array_data = array(
						"data" => $this->book_model->getWords()
						);
		header('Content-Type: application/json');
		echo json_encode($array_data);

	}

	public function generateNewWord()
	{
		$URL_API = "http://api.wordnik.com:80/v4/words.json/randomWords?hasDictionaryDef=false&minCorpusCount=0&maxCorpusCount=-1&minDictionaryCount=1&maxDictionaryCount=-1&minLength=5&maxLength=-1&limit=10&api_key=a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5";
		$response = file_get_contents($URL_API);
		echo "<pre>";
		print_r(json_decode($response));
		echo "</pre>";
	}

	private function create_question($dataWord){

		$wordChallange = array();
		
		foreach ($dataWord->dataWords as $key => $value) {
			array_push($wordChallange, 
						array(
							"id" => $value->id,
							"question"   => str_shuffle(strtolower($value->word))
						)
					);
		}

		return $wordChallange;
	}

}

?>