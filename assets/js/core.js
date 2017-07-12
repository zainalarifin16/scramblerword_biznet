$( document ).ready(function() {
 	var soal = [];
    var highScore = 0;
 	var score = 0;
    var id_question = 0;
    var question = "";
    var wordCorrect = ["Good Job", "Excellent", "Good Work", "Superb", "Skillful"];
    var wordFail = [ "Incorrect", "Not Good", "Sad", "Unacceptable", "Noobs" ];

    var get_data = function(method, url, $data = null){
    	var ajax;
    	if(method == "get")
    	{
    		ajax = $.get(url);
    	}else{
    		ajax = $.post(url, $data);
    	}

    	return ajax;

    }

    assign_question = function(){
        var last_question = soal.length;
        id_question = soal[last_question-1].id;
        question    = soal[last_question-1].question;
        $("#question_game").html( question );
        soal.pop();
        if( last_question == 2 ){
            get_data("get","http://scramblerword.biznet/WordController/generateNewWord").success(function(resultGetData){
                $(resultGetData['data']).each(function(index, data){
                    soal.push(data);
                });
            });
        }
    }

    get_data("get","http://scramblerword.biznet/WordController/index").success(function(resultGetData){
        
        $("#score_game").html(score);
        $("#high_score_game").html(highScore);
        
        $(resultGetData['data']).each(function(index, data){
            soal.push(data);
        });
        assign_question();
    });

    $("#play_now").on("click", function(){
    	$(this).hide();
    	$("#form_game").show();
    });

    $("#form_game").submit(function(e){
    	e.preventDefault();
        $data = { id: id_question,answer: $("input[name='input_user']").val() };
    	get_data("post", "http://scramblerword.biznet/WordController/answerQuestion", $data).done(function(resultPost){
            if(resultPost["answeris"]){
                score++;
                $("#feedback").html( "+1 "+wordCorrect[ Math.floor((Math.random() * (wordCorrect.length-1))) ] )
                              .css("color", "green")
                              .show();
                if( highScore < score )
                    highScore = score;
            }
            else{
                score--;
                $("#feedback").html( "-1 "+wordFail[ Math.floor((Math.random() * (wordFail.length-1))) ] + " [ correct: "+resultPost["wordcorrect"]+" ]" )
                              .css("color", "red")
                              .show();
            }
            setTimeout(function() {
                $("#feedback").hide();
            }, 2000);
            $("#score_game").html(score);
            $("#high_score_game").html(highScore);
            $("input[name='input_user']").val("");
            assign_question();
    	})
    });

 
});