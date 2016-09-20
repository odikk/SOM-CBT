<?
//This page was written by SMQ to handle the importing of questions that were exported specifically from the WebCT app. - SMQ
$userfile = $HTTP_POST_FILES['userfile']['tmp_name'];
$userfile_name = $HTTP_POST_FILES['userfile']['name'];
$userfile_size = $HTTP_POST_FILES['userfile']['size'];
$userfile_type = $HTTP_POST_FILES['userfile']['type'];

$cid = $HTTP_POST_VARS['c_id'];
$ca = $HTTP_POST_VARS['cat'];
$user = $HTTP_POST_VARS['usr_nm'];
//ensure that a file was uploaded - SMQ 8/20/2005
if ($userfile=="none")
{
	echo "Problem: no file uploaded";
	exit;
}
//ensure that the file uploaded has some content - SMQ 8/20/2005
if ($userfile_size==0)
{
	echo "Problem: uploaded file is zero length";
	exit;
}
//ensure that the file is of the correct type - alternate is binary - SMQ 8/20/2005
if ($userfile_type != "text/plain")
{
echo "Problem: file is not plain text";
exit;
}
//ensure that the file we are testing has been uploaded to the server and is not a local file - SMQ 8/20/2005
if (!is_uploaded_file($userfile))
{
echo "Problem: possible file upload attack";
exit;
}
//copy file from temporary server folder to permanent uploads dir. It is from here that we will further process the 
//file and create a database record ( or records ) of the questions. This directory is safely outside the document 
//tree - SMQ 8/20/2005.
$upfile = "/Library/WebServer/Documents/home/uploads/" .$userfile_name;

if ( !copy($userfile, $upfile))
{
echo "Problem: Could not move file into directory";  
exit;
}
//open the file - SMQ 8/20/2005
echo " -- File uploaded successfully!<br><br>";
$fp = fopen($upfile, "r");
$contents = fread ($fp, filesize ($upfile));
fclose ($fp);
//remove any html or php content from the file - SMQ 8/20/2005
//echo " -- Removing Tag content...<br><br>";
//$contents = strip_tags($contents);
$fp = fopen($upfile, "w");
fwrite($fp, $contents);
fclose($fp);

//print preview of file to browser - SMQ 8/20/2005
echo "-- Begin Populating Vocabulary...<br><hr>";
//echo $contents;
//read the file into an array - SMQ 8/22/05
$ques_arr = file( "/Library/WebServer/Documents/home/uploads/" .$userfile_name);

//print_r($ques_arr);
//Count lines in file (should exactly equal elements of array if NL delimiter makes sense) - SMQ
$linecnt = count($ques_arr);
//Loop through each line (array element) and write current line's text to var. Next, explode into a new array to pull out level and element text - SMQ

require_once('mysql_connect.php');
for($i=0;$i<$linecnt;$i++)
{
	$element_text = $ques_arr[$i];
	$element_arr1 = explode(".", $element_text);
	$last_text = array_pop($element_arr1);
	$element_arr2 = explode(" ", $last_text);
	$level = $element_arr2[0];
	array_shift($element_arr2);
	$element = implode(" ", $element_arr2);
	array_push($element_arr1, $level, $element);
	
	$levelno = count($element_arr1);
	$holder = $levelno - 1;
	$fld_towrite = '';
	$val_towrite = '';
	
	for($j=0;$j<$holder;$j++) 
	{
		$currfield = "level_".($j+1).", ";
		$val = "'".$element_arr1[$j]."', ";
		$fld_towrite = $fld_towrite . $currfield;
		$val_towrite = $val_towrite . $val;
	}
	

	$sql = "INSERT INTO usmle_vocab (voc_id, ".$fld_towrite ."element) VALUES ('', ".$val_towrite."'".$element."') "; 
	echo $sql;
	$result = @mysql_query($sql);
	if ($result) {

		echo "Question number ". $i+1 ." was successfully written to the database! <br>";
	}else{
		echo 'There was a problem writing question number '. $i+1 .' ('.$quiz_ques[ $i][0].') to the database! </font><br>';

	}
	
}
mysql_close();

/*
//WRITE TO DATABASE TABLE - SMQ	

*/
unlink($upfile);

?>