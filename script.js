function change_tweets(tweet_text,tweet_fav,tweet_ret,tweet_name,tweet_id,i)
{
    //alert(tweet_text.length);

    if(i==tweet_text.length)
    {
        i = 0;
    }

    if((tweet_text!=undefined)&&(tweet_name!=undefined))
    {
    document.getElementById("name").innerHTML = tweet_name[i];
    document.getElementById("id").innerHTML = tweet_id[i];
    document.getElementById("tweet-text").innerHTML = tweet_text[i];
    document.getElementById("fav_cnt").innerHTML = tweet_fav[i];
    document.getElementById("ret_cnt").innerHTML = tweet_ret[i];
    }

    console.log(tweet_text[i]);
    console.log(tweet_fav[i]);
    console.log(tweet_ret[i]);
    console.log(tweet_name[i]);
    console.log(tweet_id[i]);


    console.log(i);

    setTimeout(function(){
        change_tweets(tweet_text,tweet_fav,tweet_ret,tweet_name,tweet_id,i+1);
    },5000);
}

    var tweet_text = [];
    var tweet_fav  = [];            //The arrays for data;
    var tweet_ret  = [];
    var tweet_name = [];
    var tweet_id   = [];

function tweet_update()
{
    var json;
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "./tweets.php", true);
    xmlhttp.send();
    
    var scriptreq = new XMLHttpRequest();
    
    scriptreq.onreadystatechange=function()
    {
    if (scriptreq.readyState==4 && scriptreq.status==200)
        {
            json = JSON.parse(scriptreq.responseText);
    var x = 0;
    var i;
    for(i=0;i<json.length;i++){
        
        tweet_text[i] = json[i]['text'];
        tweet_fav[i] = json[i]['fav'];
        tweet_ret[i] = json[i]['ret'];
        tweet_name[i] = json[i]['name'];
        tweet_id[i] = json[i]['id'];
    }
    
        }
    }
    scriptreq.open("GET", "./jsontweets.php", true);
    scriptreq.send();
    
    
    setTimeout(function(){
        tweet_update();
        document.write("<?php addtweets(); ?>");
    },900000);
}

setTimeout(function(){
    tweet_update();
    setTimeout(function(){
    change_tweets(tweet_text,tweet_fav,tweet_ret,tweet_name,tweet_id,0);
    },1000);
},1500);