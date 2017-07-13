<?php
/**
* Class Controller
*/

include_once("model/bookmodel.php");

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
		$dataWord = $this->book_model->getWord($data["id"]);
		$result = array(
					'answeris' => ( strtolower($_POST["answer"]) === strtolower($dataWord["word"]) ),
					'wordcorrect' => $dataWord["word"]
				);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	//get
	public function addWord(){
		$word = $_POST;
		$result = false;
		if($word != null){
			foreach ($word['data'] as $key => $value) {
				# code...
				$word['data'][ $key ] = (object) $word['data'][ $key ];
			}
			if($this->book_model->batchAddWords($word['data']))
				$result = true;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
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
		$URL_API = "http://api.wordnik.com:80/v4/words.json/randomWords?hasDictionaryDef=true&includePartOfSpeech=verb&excludePartOfSpeech=idiom&minCorpusCount=0&maxCorpusCount=-1&minDictionaryCount=1&maxDictionaryCount=-1&minLength=5&maxLength=-1&limit=10&api_key=a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5";

		$result_api = json_decode( file_get_contents($URL_API) );

		$sync_db = $this->book_model->batchAddWords($result_api);

		$response = array();
		$response['dataWords'] = $sync_db;

		$wordChallange = $this->create_question( (object) $response);

		$array_respon = array(
						"data" => $wordChallange
						);
		header('Content-Type: application/json');
		echo json_encode($array_respon);

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