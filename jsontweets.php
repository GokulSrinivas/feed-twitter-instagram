<?php
    
$username = "festember_feed";
$password = "4EKN9N8sFQHz3DZ2";
$host = "localhost";


    // Connecting to the database
    $db = mysql_connect($host, $username, $password)
            or die("Database Connection Failed");

    $tab = mysql_select_db("festember_feed", $db)
            or die("Unexpected Problem. Please try again.");

    $query = "SELECT * FROM tweets ORDER BY ret DESC";
    $result = mysql_query($query);

    $row_cnt = mysql_num_rows($result);

    $json = array();
    if($row_cnt>=10)
    {
        $row_cnt = 10;
            }


    for($i=0;$i<$row_cnt;$i++)
    {
        $tweet_text = mysql_result($result,$i,"text");
        $tweet_fav  = mysql_result($result,$i,"fav");
        $tweet_ret  = mysql_result($result,$i,"ret");               // Data from the database
        $tweet_name = mysql_result($result,$i,"name");
        $tweet_id   = mysql_result($result,$i,"id");
//        $tweet_text = stripslashes(json_encode(utf8_encode($tweet_text)));
        $tweet_text = utf8_encode($tweet_text);
//        echo("<script>");

$k = array(
     "text" => $tweet_text,
     "fav" => $tweet_fav,
     "ret" => $tweet_ret,
     "name" =>$tweet_name,
     "id" =>$tweet_id
);

        array_push($json,$k);
        
    }
    
    echo json_encode($json);


        /*
        echo("tweet_text[$i] = '$tweet_text';");
        echo("tweet_fav[$i]  = '$tweet_fav';");
        echo("tweet_ret[$i]  = '$tweet_ret';");
        echo("tweet_name[$i] = '$tweet_name';");
        echo("tweet_id[$i]   = '@$tweet_id';");
//        echo("</script>\n");
        */
        
        
        
     /*
        echo("console.log('$tweet_text');");
        echo("console.log('$tweet_fav');");
        echo("console.log('$tweet_ret');");
        echo("console.log('$tweet_name');");
        echo("console.log('@$tweet_id');");

    /*
        echo($tweet_text);
        echo($tweet_fav);
        echo($tweet_ret);
        echo($tweet_name);
        echo($tweet_id);
    */

//    echo("<script>");
/*
    echo("setTimeout(function(){");
    echo("change_tweets(tweet_text,tweet_fav,tweet_ret,tweet_name,tweet_id,0);");
    echo("},5000);");
//    echo("</script>  ");
    exit;
    
    */
?>