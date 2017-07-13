<?php
/**
* Book Model
*/
include_once("model/word.php");
class BookModel
{
	public $dataWords = array();
	private $create_table = "CREATE TABLE `questions` (
							  `id` INT NOT NULL AUTO_INCREMENT,
							  `word` VARCHAR(45) NULL,
							  PRIMARY KEY (`id`));";

	function __construct()
	{
		$this->initWords();
	}

	public function initWords(){
		$db = Db::getInstance();

		try {
        	$db->query("SELECT * FROM questions");
	    } catch (PDOException $e) {
	        if($e->getCode() == "42S02"){
	        	$db->query($this->create_table);
	        	$insert_data = $db->prepare("INSERT INTO questions VALUES(null, :word)");
	        	$insert_data->execute( array( 'word' => "Reading") );
	        	$insert_data->execute( array( 'word' => "Speaking") );
	        	$insert_data->execute( array( 'word' => "Writing") );
	        }
	    }
		
	    $select_10 = $db->prepare("SELECT * FROM questions ORDER BY rand() LIMIT 10");
	    $select_10->execute();

	    while( $question = $select_10->fetch(PDO::FETCH_ASSOC) ) {
	    	# code...
	    	array_push($this->dataWords, new Word($question["id"], $question["word"]));
	    }

		return $this->dataWords;

	}

	public function addWords($word){
		$db = Db::getInstance();

		try {
			$insert_data = $db->prepare("INSERT INTO questions VALUES(null, :word)");
	    	$insert_data->execute( array( 'word' => $word ) );
			return $db->lastInsertId();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function batchAddWords($words){
		$result = array();
		foreach ($words as $key => $value) {
			# code...
			array_push($result, (object)array( 'id' => $this->addWords($value->word), 'word' => $value->word ));
		}
		return $result;
	}

	public function getWord($id){
		$db = Db::getInstance();
		$select_data = $db->prepare("SELECT * FROM questions WHERE id=:id");
		$select_data->execute( array( 'id' => $id ) );
		return $select_data->fetch( PDO::FETCH_ASSOC );
	}

	public function getWords(){
		return $this->dataWords;
	}

}
?>