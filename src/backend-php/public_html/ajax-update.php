<?php
/* Copyright 2011 Cambridge Design Research LLP.
* All rights reserved.
*
* This file is part of Canvas.
* Canvas is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Canvas is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Lesser General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Canvas.  If not, see <http://www.gnu.org/licenses/>.
*
* Alternatively, this file may be used in accordance with the terms and
* conditions contained in a signed written agreement between you and
* Cambridge Design Research LLP.
*/
	include "../includes/config.php";

	$id = $_GET["id"];
	$x = $_GET["x"];
	$y = $_GET["y"];
	$z = $_GET["z"];
	$size = $_GET["size"];
	$rotation = $_GET["rotation"];

	//Find latest sequence number
	$query = "SELECT MAX(sequence) FROM content";
	$result = mysql_query($query) or die(mysql_error()); 
	$row = mysql_fetch_array($result);
	$sequence = $row['MAX(sequence)'] + 1;	//Increment Sequence
	
	//Update data in table
	$query = "UPDATE content SET x='$x', y='$y', z='$z', size='$size', rotation='$rotation', sequence='$sequence' WHERE id='$id'";
	$result = mysql_query($query) or die(mysql_error());  
	echo $sequence;							//Return sequence to main program
?>
