<?php

ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
if (array_key_exists("url", $_GET) == false)
{
	print("{\"error\" : \"URL not supplied\"}");
	return 0;
}
$videoUrl = urldecode($_GET["url"]); //"http://www.youtube.com/watch?v=6iK4dy74ibY";
//$videoUrl = "http://www.youtube.com/watch?v=4q5ZHU8yvLQ";

chdir(dirname(dirname(getcwd()))."\\objects");
$path  = dirname(getcwd())."\\scripts\\youtube-dl.py";

exec("C:\\Python27\\python.exe " . $path . " " . escapeshellarg($videoUrl)." -F", $result);

//print_r($result);
$imploded = implode("\n", $result);

//$numWebm = preg_match_all ("(\n([0-9]{2}).*webm)", $imploded, $matches); // all webm formats
$numWebm = preg_match_all ("(\n(4[3-4]{1}).*webm)", $imploded, $matches); // 43 and 44 only

$formats = $matches[1];
rsort($formats);

if (count($formats) > 0)
{
	$format = $formats[0];
	exec("C:\\Python27\\python.exe " . $path . " " . escapeshellarg($videoUrl)." -f ". $format ." -w --write-info-json", $result2);
	//print_r($result2);
	$imploded = implode("\n", $result2);
	
	preg_match("(JSON to: (.*json))", $imploded, $matches);
	
	$json_file = $matches[1];
	//echo "JSON file: ".$json_file."\n";
	$json = file_get_contents($json_file);
	$decoded_json = json_decode($json, true);
	$Downloaded = preg_match("(Destination: (.*))", $imploded, $matches);
	if ($Downloaded == 0)	
	{
		preg_match("((.*).info.json)", $json_file, $matches);
	}
	$file = $matches[1];
	
	$decoded_json["filename"] = $file;
	$json = json_encode($decoded_json);
	echo $json;
	//if (copy(getcwd()."\\".$file, dirname(getcwd())."\\objects\\".$file)) {
	//	unlink(getcwd()."\\".$file);
		unlink(getcwd()."\\".$json_file);
		if ($Downloaded != 0) unlink(getcwd()."\\".$file.".progress.json");
	//}
}
else
{
	print("{\"error\" : \"NO WEBM FORMAT\"}");
}
?>