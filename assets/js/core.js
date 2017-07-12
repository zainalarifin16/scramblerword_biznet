$( document ).ready(function() {
 	var soal = [];
 	var score = 0;
    var id_question = 0;
    var question = "";

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
    }

    get_data("get","http://scramblerword.biznet/WordController/index").success(function(resultGetData){
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
        $data = { answer: $("input[name='input_user']").val() };
    	get_data("post", "http://scramblerword.biznet/WordController/answerQuestion", $data).done(function(resultPost){
            console.log(resultPost);
    		score += 1;
	    	$("#score_game").html(score);
	    	$("input[name='input_user']").val("");
            assign_question();
    	})
    });

 
});