$( document ).ready(function() {
 	var soal = [];
 	var score = 0;

    $("#play_now").on("click", function(){
    	$(this).hide();
    	$("#form_game").show();
    });

    $("#form_game").submit(function(e){
    	e.preventDefault();
    	score += 1;
    	$("#score_game").html(score);
    });

    var get_data = function(method, url){
    	var ajax;
    	if(method == "get")
    	{
    		ajax = $.get(url);
    	}else{
    		ajax = $.post(url);
    	}

    	ajax.success(function(dataResult){
    		console.log( dataResult );
    	});

    }

    get_data("get","http://scramblerword.biznet/WordController/index");
 
});