<?php

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
if (array_key_exists("url", $_GET) == false)
{
	print("{\"error\" : \"URL not supplied\"}");
	return 0;
}

$videoUrl = urldecode($_GET["url"]); //"http://www.youtube.com/watch?v=6iK4dy74ibY";
//$videoUrl = "http://www.youtube.com/watch?v=4q5ZHU8yvLQ";

$path  = dirname(getcwd())."\\scripts\\youtube-dl.py";

exec("C:\\Python27\\python.exe " . $path . " " . $videoUrl." --write-info-json --skip-download", $result);
$imploded = implode("\n", $result);
preg_match("(JSON to: (.*json))", $imploded, $matches);
$json_file = $matches[1];
$json = file_get_contents($json_file);
echo $json;
?>