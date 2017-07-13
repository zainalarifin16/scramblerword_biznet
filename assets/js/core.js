$( document ).ready(function() {

    var base_url = (window.location.href).replace("#","");

 	var soal = [];
    var highScore = ( typeof localStorage.highScore != "undefined" )? localStorage.highScore : 0;
 	var score = 0;
    var id_question = 0;
    var question = "";
    var wordCorrect = ["Good Job", "Excellent", "Good Work", "Superb", "Skillful"];
    var wordFail = [ "Incorrect", "Not Good", "Sad", "Unacceptable", "Noobs" ];
    var adminPass = "c2F5YSBzdXBlciBhZG1pbg==";

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

    $("#access_admin").on("click", function(e){
        e.preventDefault();
        $("#modal_admin").show();
    });

    $( $(".close")[0] ).on("click", function(e){
        $("#modal_admin").hide();

    });

    $(window).on("click", function(e){
        if( e.target == $("#modal_admin") ){
            $("#modal_admin").hide();
        }
    });

    $("#word_system").submit(function(e){
        e.preventDefault();
        var userInput = $("input[name='magic_word']").val();
        if(btoa(userInput) == adminPass){
            $(this).hide();
            $("input[name='magic_word']").val("");
            $("#input_word").show();
        }else{
            $("#feedback_system").show();
            $("#feedback_system").html("WRONG MAGIC WORD!").css("color","red");
            setTimeout(function() {
                $("#feedback_system").hide();
            }, 1000);
        }
    });

    $("#add_more").on("click", function(e){
        e.preventDefault();
        $(this).before( $("#text_word").clone().val("") ).before($("<br/>"));
    });

    $("#input_word").submit(function(e){
        e.preventDefault();
        $("#word_system").show();
        $("#modal_admin").hide();

        var input_user = $("form#input_word input[type='text']");
        var dataWord = [];
        input_user.each(function(index, data){
            if($(data).val() != ""){
                dataWord.push( { word: $(data).val() } );
            }
        });
        console.log(dataWord);
        get_data("post", base_url+"WordController/addWord", { data: dataWord }).done(function(resultPost){
            console.log(resultPost);
        });

        $(this).html('<input id="text_word" type="text" name="word[]"><br/><button id="add_more" >Add More</button><button type="submit" >Save</button>').hide();
        $("#add_more").on("click", function(e){
            e.preventDefault();
            $(this).before( $("#text_word").clone().val("") ).before($("<br/>"));
        });

    });

    assign_question = function(){
        var last_question = soal.length;
        id_question = soal[last_question-1].id;
        question    = soal[last_question-1].question;
        $("#question_game").html( question );
        soal.pop();
        if( last_question == 2 ){
            get_data("get",base_url+"WordController/generateNewWord").success(function(resultGetData){
                $(resultGetData['data']).each(function(index, data){
                    soal.push(data);
                });
            });
        }
    }

    get_data("get",base_url+"WordController/index").success(function(resultGetData){
        
        //setup facebook
        $("#og_url").attr("content", base_url );
        $("#og_type").attr("content", "website" );
        $("#og_title").attr("content", $("title").html() );
        $("#og_desc").attr("content", $("meta[name='Description']").attr("content") );

        $("#score_game").html(score);
        $("#high_score_game").html(highScore);

        $(resultGetData['data']).each(function(index, data){
            soal.push(data);
        });
        console.log(base_url+"WordController/index");
        console.log(resultGetData);
        assign_question();
    });

    $("#play_now").on("click", function(){
    	$(this).hide();
    	$("#form_game").show();
    });

    $("#share_fb").on("click", function(e){
        e.preventDefault();
        FB.ui({
            method: 'share',
            display: 'popup',
            mobile_iframe: true,
            quote: "My High Score : "+highScore+", can you beat me at "+base_url,
            href: base_url,
          }, function(response){});
    });

    $("#share_twitter").on("click", function(e){
        e.preventDefault();
        window.open("https://twitter.com/share?url="+base_url+"&amp;text=My High Score : "+highScore+", can you beat me at &amp;hashtags=ScramblerWordBiz", "Share your score Scrambler Word Biz", "width=500,height=400");
    })

    $("#form_game").submit(function(e){
    	e.preventDefault();
        var data = { id: id_question,answer: $("input[name='input_user']").val() };
    	get_data("post", base_url+"WordController/answerQuestion", data).done(function(resultPost){
            if(resultPost["answeris"]){
                score++;
                $("#feedback").html( "+1 "+wordCorrect[ Math.floor((Math.random() * (wordCorrect.length-1))) ] )
                              .css("color", "green")
                              .show();
                if( highScore < score ){
                    highScore = score;
                    localStorage.setItem("highScore", highScore);
                }
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