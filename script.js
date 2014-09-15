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
    },2000);
}


