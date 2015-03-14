<?php

error_reporting(0);
define('DIRECTORY', './uploads');

// The Hashtag and Count variables

$hash = "festember";
$cnt = "20";

// Instagram Credentials
$clientid = "";  //Your CLient ID
$accesstoken = "";    //Your Access Token

//Base API Request
$req = 'https://api.instagram.com/v1/tags/'.$hash.'/media/recent?callback=?&count='.$cnt.'&access_token='.$accesstoken;


$req2 = $req;

do
{


$ch = curl_init($url);

curl_setopt($ch, CURLOPT_CONNECTTIMEOUeT, 20);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($ch);

// Getting the JSON from the API


$are = file_get_contents($req2);
$pics = json_decode($are);
$min_tag_id = $pics->pagination->min_tag_id;

// Creating the request for the next set of pictures/posts
$req2 = $req."&min_tag_id=".$min_tag_id;


$data = $pics->data;  //The Array of posts/pictures

for($i=0;$i<count(data);$i++)
{

//var_dump($data[$i]);

$url = $data[$i]->images->standard_resolution->url; //url of the picture
$likes  = $data[$i]->likes->count; //number of likes
$username = $data[$i]->user->username; // user who has uploaded the photo

$picurl = explode("/",$url);
$picname = $picurl[count($picurl)-1]; //name of the picture

echo($picname." ".$likes." ".$username."<br>"); //prints the picture name followed by likes and username

//saving it in the folder

$content = file_get_contents("$url");
file_put_contents(DIRECTORY."/$picname.jpg", $content);
}

} while(isset($min_tag_id));
?>
