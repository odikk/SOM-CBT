<?//The following page handles the uploading of questions from WebCT. This page was created by Sean M. Quigley - Dept. Neuroscience, Cell Biology & Physiology$userfile = $HTTP_POST_FILES['userfile']['tmp_name'];$userfile_name = $HTTP_POST_FILES['userfile']['name'];$userfile_size = $HTTP_POST_FILES['userfile']['size'];$userfile_type = $HTTP_POST_FILES['userfile']['type'];$cid = $HTTP_POST_VARS['c_id'];$qid = $HTTP_POST_VARS['q_id'];//ensure that a file was uploaded - SMQ 8/20/2005if ($userfile=="none"){	echo "Problem: no file uploaded";	exit;}//ensure that the file uploaded has some content - SMQ 8/20/2005if ($userfile_size==0){	echo "Problem: uploaded file is zero length";	exit;}//ensure that the file is of the correct type - alternate is binary - SMQ 8/20/2005if ($userfile_type != "text/plain"){echo "Problem: file is not plain text";exit;}//ensure that the file we are testing has been uploaded to the server and is not a local file - SMQ 8/20/2005if (!is_uploaded_file($userfile)){echo "Problem: possible file upload attack";exit;}//copy file from temporary server folder to permanent uploads dir. It is from here that we will further process the //file and create a database record ( or records ) of the questions. This directory is safely outside the document //tree - SMQ 8/20/2005.$upfile = "/Library/WebServer/Documents/home/uploads/" .$userfile_name;if ( !copy($userfile, $upfile)){echo "Problem: Could not move file into directory";  exit;}//open the file - SMQ 8/20/2005echo " -- File uploaded successfully!<br><br>";$fp = fopen($upfile, "r");$contents = fread ($fp, filesize ($upfile));fclose ($fp);//remove any html or php content from the file - SMQ 8/20/2005echo " -- Removing Tag content...<br><br>";$contents = strip_tags($contents);$fp = fopen($upfile, "w");fwrite($fp, $contents);fclose($fp);//print preview of file to browser - SMQ 8/20/2005echo "-- Begin Question Delineation...<br><hr>";//echo $contents;//read the file into a string or BLOB - SMQ 8/22/05$ques_blob = file_get_contents( "/Library/WebServer/Documents/home/uploads/" .$userfile_name);//tag all carriage return white space for better delineation of question numbers and answer options - SMQ 8/22/2005$ques_blob = ereg_replace("\r", "^", $ques_blob);//since '*' is the only thing that we can assume is unique to each question (with any confidence), use this as a first//pass to get an exact value representing the total number of questions - SMQ 8/22/05$ques_arr = explode("*", $ques_blob);$ques_cnt = count($ques_arr);//now use the total number of questions to tell us how many times to loop through the array and try to find a question //based on the string "X.", where X is a numeric value 1, 2, 3...etc. and when combined with "." should give us an idea//of where a question begins - SMQ 8/22/05for ($i=1; $i<$ques_cnt; $i++)  {	$qnum = $i;	$qval = strval($qnum);	$qval = "^".$qval.". ";	$arrnumber[$qnum] = $qval;  }//tag the 'general feedback' sections - SMQ 8/22$ques_blob = str_replace( "General Feedback:", "]>", $ques_blob);//tag the question sections - SMQ 8/22$ques_blob = str_replace( "1. ", "$", $ques_blob);$ques_blob = str_replace($arrnumber, "$", $ques_blob);//tag the answer option sections - SMQ 8/22$arr_options = array("^a.", "^b.", "^c.", "^d.", "^e.");$ques_blob = str_replace($arr_options, "]", $ques_blob);//handle the option/answer identifier - SMQ 8/22$arr_options2 = array("*a.","*b.","*c.","*d.","*e.");$ques_blob = str_replace($arr_options2, "*]", $ques_blob);//replace carriage return and whitespace delineator with a space - SMQ 8/28$ques_blob = str_replace("^", " ", $ques_blob);//build array of question sections - SMQ 8/22$ques_ques = explode("$", $ques_blob);$qcnt = count($ques_ques);//Now, for each question section, we need to pull out all of the pertinent sub-sections - SMQ 8/28for ($i=0; $i<$qcnt; $i++)  {//write each question section to a string - SMQ  	$ques_str1 = $ques_ques[ $i];//get answer options - SMQ  	$ques_optn = explode("]", $ques_str1);  	$optcnt = count($ques_optn);	$optlast = $optcnt-1;  	$gettext = $ques_optn[ 0];  		$txt = explode(" ", $gettext);  		$textcnt = count($txt);  		$txtuplngth = $txtcnt; 	$subtxt = array_slice($txt, 1, -1);	$txtstr = implode(" ", $subtxt);  	$getqname = $txt[ 0];	$getfeed = $ques_optn[ $optlast];	$lookfeed = explode(">", $getfeed);	$countfeed = count($lookfeed);		if(!isset($lookfeed[ 1]))	  {	    $feedbck = "none";		$options = array_slice($ques_optn, 1);	  }	else	  {	  	$feedbck = $lookfeed[ 1];		$options = array_slice($ques_optn, 1, -1);	  }	  if(!isset($options[ 4]))	  {	  	$options[ 4] = "None";	  }	for ($j=0; $j<5; $j++)	  {	    $optget = $options[ $j];	    if(stristr($optget, '*') === FALSE)		{			$answer[ $j]= "0";			$choice[$j] = $optget;		}		else		{			$answer[ $j] = "0";			$choice[$j] = str_replace("*", "", $optget);			$j = $j+1;			$answer[ $j] = "1";					}				}	$answer[5] = '';		$answers = implode("#", $answer);		  	$quiz_ques[ $i] = array($getqname, $txtstr, $feedbck, $answers, array($choice));//check on this  }require_once('mysql_connect.php');				for ($i=1; $i < count($quiz_ques); $i++){				$sql = "INSERT INTO questions VALUES ('', '".$cid."', '".$qid."', '".$quiz_ques[ $i][0]."', '".$quiz_ques[ $i][1]."', '".$quiz_ques[ $i][4][0][0]."', '".$quiz_ques[ $i][4][0][1]."', '".$quiz_ques[ $i][4][0][2]."', '".$quiz_ques[ $i][4][0][3]."', '".$quiz_ques[ $i][4][0][4]."', '1', '".$quiz_ques[ $i][3]."', '".$quiz_ques[ $i][2]."', ' ', '0', 'admin', 'admin', ".time().", '0', 'somesource', '1') "; 		$result = @mysql_query($sql);		echo '<a href="javascript:history.back();"><strong>Return to Previous Page</strong></a>';		if ($result) {			echo "Question number ".$i."was successfully written to the database! <br>";		}else{		echo '<font color="red">There was a problem writing question number '.$i.' to the database! </font><br>';		}}mysql_close();?>