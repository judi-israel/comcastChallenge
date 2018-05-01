<!DOCTYPE html>
<html lang="en">
<!--
	author: Judi Israel
	date:	Apr. 30, 2018
	Challenge:
		For this challenge, you are asked to create an index.php script that renders a web page. The script should render a minimal web page that displays the current weather conditions in Philadelphia, PA. You are asked to use the Weather Underground API (https://www.wunderground.com/weather/api) as your data source. Upon loading of the page, please connect to the API to get the conditions and display them to the page as an HTML table. In addition, please include (print on the web page) a SQL INSERT statement that would store the temperature and humidity into a SQL database along with the timestamp. For simplicity, you may use fictitious table and field names. Please upload your project to github and provide send me back the URL to the project. This project should take between one and four hours to complete depending on familiarity with the associated technologies.
-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Comcast Coding Challenge</title>

	<style>
		table {
    			border-collapse: collapse;
    			width: 80%;
		}
		table, th, td {
    			border: 1px solid black;
		}
		th, td {
    			padding: 15px;
    			text-align: left;
		}
		tr:nth-child(even) {
    			background-color: #f2f2f2;
		}
		th {
    			background-color: #4CAF50;
   			color: white;
		}
		.myPadding {
			padding-top: 20px;
		}
		.myPadding2 {
			padding-top: 40px;
		}
	</style>
</head>

<body>

<?php

  // API call to wunderground to get weather conditions for Philadelphia. I previously requested a key, seen below as c11...
  $json_string 	= file_get_contents("http://api.wunderground.com/api/c11e5e581e7a1c18/geolookup/conditions/q/PA/Philadelphia.json");

  // parse the json return from the API call
  $parsed_json 	= json_decode($json_string);

  // to see all data returned from API:
  // echo( "<pre>" );
  // print_r( $parsed_json );
  
  // pull individual pieces of data from the parsed json
  $location 	= $parsed_json->{'location'}->{'city'};

  $temp 	= $parsed_json->{'current_observation'}->{'temperature_string'};
  $tempForDB 	= $parsed_json->{'current_observation'}->{'temp_f'};
  $time 	= $parsed_json->{'current_observation'}->{'local_time_rfc822'};
  $relHum 	= $parsed_json->{'current_observation'}->{'relative_humidity'};

  // relHum has percent as last char. Remove last char before adding to db in the below insert
  $relHumNoPC 	= substr( $relHum, 0, -1 );
  // echo( "relHum is $relHumNoPC<br>" );
  $wind 	= $parsed_json->{'current_observation'}->{'wind_string'};
  $feelsLike 	= $parsed_json->{'current_observation'}->{'feelslike_string'};
  $precip 	= $parsed_json->{'current_observation'}->{'precip_today_string'};
  
  echo "<table>";
    echo "<tr>";
    echo "<th colspan='2'>Weather Conditions for $location</th>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Local Time:</td>";
    echo "<td>$time</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Current Temp:</td>";
    echo "<td>$temp</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Relative Humidity:</td>";
    echo "<td>$relHum</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Wind:</td>";
    echo "<td>$wind</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Feels Like:</td>";
    echo "<td>$feelsLike</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Precip:</td>";
    echo "<td>$precip</td>";
    echo "</tr>";
  echo "</table>";
  
?>

  <p class="myPadding">For a full weather forecast: <a href='http://www.wunderground.com/US/PA/Philadelphia.html'>http://www.wunderground.com/US/PA/Philadelphia.html</a></p>
  
  <p class="myPadding2">I'm not sure I understand so I hope I am answering what you want. You only want me to print the INSERT? If so, here it is (for mysql):<br>
  INSERT INTO weatherTable (Temperature,Humidity,Timestamp ) VALUES ( $tempForDB . ',' . $relHumNoPC . ',' . NOW() );</p>

  <p class="myPadding">If you wanted the connection string, I would create an .ini file outside of the web directory with the username, password and hostname, read the .ini file and create the connection string.</p>

</body>
</html>
