<! DOCTYPE html>
<html>
    <head>
        <title>
        Festember 2K14
        </title>

        <script type="text/javascript" src="includes/jquery/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="includes/bootstrap-3.2.0-dist/js/bootstrap.js"></script>
        <script type="text/javascript" src="script.js"></script>

        <link rel="stylesheet" href="includes/bootstrap-3.2.0-dist/css/bootstrap.css">
        <link rel="stylesheet" href="feedstyle.css">
    </head>
    <body>
<!-- The twitter body starts here        -->
        <div id="centerdiv">
            <img id="comp_logo" src="imgs/twitter.png">

            <div id="user">
                <div id="name">Gokul Srinivas</div>
                <div id="id">@GokulSrinivas23</div>
            </div>
            <div id="data">
                <img id="openq" src="imgs/openq.png">
                <br>
                <div id="tweet-text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante ante.
                Lorem ipsum dolor sit amet, consectetur.
                </div>
                <img id="closeq" src="imgs/closeq.png">
            </div>
            <div id="prop">
                <div id="fav"> Favorites: <div id="fav_cnt"> 5 </div> </div>
                <div id="ret"> Retweets : <div id="ret_cnt"> 5 </div> </div>
            </div>
        </div>
        <img id="delta_logo" src="imgs/delta.png">
<!--The Twitter body ends here        -->
<!--The Javascript to change the tweets starts here    -->
    <script type="text/javascript">

    var tweet_text = [];
    var tweet_fav  = [];            //The arrays for data;
    var tweet_ret  = [];
    var tweet_name = [];
    var tweet_id   = [];
</script>

<?php
    // Database credentials
    $username = "root";
    $password = "stein238";
    $host = "localhost";

    // Connecting to the database
    $db = mysql_connect($host, $username, $password)
            or die("Database Connection Failed");

    $tab = mysql_select_db("feed", $db)
            or die("Unexpected Problem. Please try again.");

    $query = "SELECT * FROM tweets ORDER BY ret DESC";
    $result = mysql_query($query);

    $row_cnt = mysql_num_rows($result);

    for($i=0;$i<$row_cnt;$i++)
    {
        $tweet_text = mysql_result($result,$i,"text");
        $tweet_fav  = mysql_result($result,$i,"fav");
        $tweet_ret  = mysql_result($result,$i,"ret");               // Data from the database
        $tweet_name = mysql_result($result,$i,"name");
        $tweet_id   = mysql_result($result,$i,"id");
        $tweet_text = json_encode(utf8_encode($tweet_text));
        echo("<script>");


        echo("tweet_text[$i] = '$tweet_text';");
        echo("tweet_fav[$i]  = '$tweet_fav';");
        echo("tweet_ret[$i]  = '$tweet_ret';");
        echo("tweet_name[$i] = '$tweet_name';");
        echo("tweet_id[$i]   = '@$tweet_id';");
        echo("</script>\n");
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
    }

    echo("<script>");
    echo("setTimeout(function(){");
    echo("change_tweets(tweet_text,tweet_fav,tweet_ret,tweet_name,tweet_id,0);");
    echo("},1000);");
    echo("</script>  ");
?>
    </body>
</html>
