<?php

require('./TwitterAPIExchange.php');

// Twitter API Credentials

$settings = array(
    'oauth_access_token' => "Your-Oauth-Access-Token",
    'oauth_access_token_secret' => "Your-Oauth-Access-Token-Secret",
    'consumer_key' => "Your-Consumer-Key",
    'consumer_secret' => "Your-Consumer-Key-Secret"
);


// Database credentials
$username = "mysql-Username";
$password = "mysql-Password";
$host = "Servername";

// Connecting to the database
$db = mysql_connect($host,$username,$password)
        or die("Database Connection Failed");

$tab = mysql_select_db("feed",$db)
        or die("Unexpected Problem. Please try again.");

// Receiving tweets and adding to the database

$refurl = '?q=%23festember';

do
{
// Making the request to the API
$url = 'https://api.twitter.com/1.1/search/tweets.json';    //Base URL
$getfield = $refurl;                                        //The get parameters
$requestMethod = 'GET';                                     //Request method - GET since we need to fetch the posts
$twitter = new TwitterAPIExchange($settings);               //Creating a new object of the APIExchange Class
$s = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();                            //Performing the request and storing the JSON.

$sdecode = json_decode($s,$a=TRUE);                         //Decoding the JSON

foreach($sdecode['statuses'] as $tweet)
{
//    var_dump($tweet);
//    var_dump($tweet['text']);   //tweet contents
//    echo("   ");
//    var_dump($tweet['favorite_count']);  // favorite count of tweet
//    echo("   ");
//    var_dump($tweet['retweet_count']);
//    var_dump($tweet['user']['name']);
//    var_dump($tweet['user']['screen_name']);
//    //var_dump($tweet['screen_name']);


    $tweet_text = $tweet['text'];                               // Tweet text
    $tweet_fav = $tweet['favorite_count'];                      // Number of favourites
    $tweet_ret = $tweet['retweet_count'];                       // Number of Re-Tweets
    $tweet_name = $tweet['user']['name'];                       // Name of the person
    $tweet_username = $tweet['user']['screen_name'];            // twitter id (comes without the @)

    echo($tweet_text);
    echo($tweet_fav);
    echo($tweet_ret);
    echo("@".$tweet_username);

    echo("<br><br>");

    //adding the tweets and the details to the database

    $query = "SELECT * FROM tweets where text='$tweet_text' and id='$tweet_username'";
    $result = mysql_query($query);

    if(mysql_num_rows($result)==0)    //No duplicate tweets detected
    {
        $query = "INSERT INTO tweets VALUES ('$tweet_text','$tweet_fav','$tweet_ret','$tweet_name','$tweet_username')";
        $result = mysql_query($query);
    }
    else                              //Duplicate tweets detected and deleted
    {
        $cnt = mysql_num_rows($result);
        for($i=0;$i<$cnt;$i++)
        {
            $text = mysql_result($result,$i,"text");
            $name = mysql_result($result, $i, "name");
            $id = mysql_result($result, $i, "id");

            $query = "delete from tweets where text='$text' and id='$id'" ;
            $result = mysql_query($query);

            $query = "INSERT INTO tweets VALUES ('$tweet_text','$tweet_fav','$tweet_ret','$tweet_name','$tweet_username')";
            $result = mysql_query($query);
        }
    }


}

// URL for the next set of tweets

$refurl = $sdecode['search_metadata']['query'].explode("&",$sdecode['search_metadata']['refresh_url'])[0];


} while(isset($sdecode['search_metadata']['refresh_url']));
