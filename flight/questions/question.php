<?php

class question {

	var $quesid = 0 ; // question
	var $qtype = 0 ; // question type
	var $ca = 0 ; // category
	var $cid = 0 ; // course
	var $qzid = 0 ; //quiz - added by SMQ
	var $lock = 'n' ; //quiz locked flag - added by SMQ
	var $qvalues = array();
	var $points = array();
	
	function setIDs ($cid, $ca, $qtype, $uid, $quesid = 0, $qzid = 0, $lock = 'n') {
		$this->userid = $uid ;
		$this -> cid = $cid;
		$this -> ca = $ca;
		$this -> quesid = $quesid ;
		$this -> qtype = $qtype ;
		$this -> qzid = $qzid ;
		$this -> lock = $lock ;
	}

	function setValue( $val) {
		$this -> points = explode("#",$val['points']);
		$this -> qvalues = $val;
	}	
	
	function operation($oper="") {
	
		$this->file_browser = append_sid('file_browser.php?ARG1='.$this->cid);
//		$this->stats_link = append_sid('stats.php?ARG1='.$this->cid.'&ARG2='.$this->ca.'&ARG3='.$this->quesid, true);
//		$this-> stats_link = $this->quesid;	
		
		switch($this-> qtype) {
			
			case MULTIPLECHOICE : 
			{
				switch ($oper) {
				
					case  "add" :
					{
						$this->qvalues['operation'] = 'addresp';
						$ret_value = $this->get_file_contents('multichoice.php');
						break;
					}
					
					case "addresp" :
					{
						$ret_value = "INSERT INTO ". QUESTIONS_TABLE . " (cat_id, course_id, ques_name, stem, choice1, choice2, choice3, choice4, choice5, media_name, points, feedback, qtype, createdby,  lastedited_by, lastedited_date) 
										VALUES (".$this -> ca.",".$this -> cid.",'".$this->qvalues['qname']."','".$this->qvalues['qstem']."','".$this->qvalues['qch1']."',
													'".$this->qvalues['qch2']."','".$this->qvalues['qch3']."','".$this->qvalues['qch4']."','".$this->qvalues['qch5']."', '".$this->qvalues['media_name']."', '".$this->qvalues['points']."','".$this->qvalues['feedback']."', '1', ".$this->userid.",".$this->userid.",".time().")";
						break;
					}
					
					case "save" :
					{
						$ret_value = "UPDATE ". QUESTIONS_TABLE ." SET 
										ques_name = '".$this->qvalues['qname']. "', stem = '".$this->qvalues['qstem']."', choice1 = '".$this->qvalues['qch1']."',
									   choice2 = '".$this->qvalues['qch2']."', choice3 = '".$this->qvalues['qch3']."', choice4 = '".$this->qvalues['qch4']."',
									   choice5 = '".$this->qvalues['qch5']."', media_name = '".$this->qvalues['media_name']."', feedback = '".$this->qvalues['feedback']."', lastedited_by = ".$this->userid." , lastedited_date = ".time()." ,
									   points = '".$this->qvalues['points']. "' WHERE question_id = ".$this->quesid;
						break;
					}
					case "save_pnts" :
					{
						$ret_value = "UPDATE ". QUIZ_QUESTIONS_TABLE ." SET 
										lastedited_by = ".$this->userid." , lastedited_date = ".time()." ,
									   points = '".$this->qvalues['points']. "' WHERE quiz_id = ".$this->qzid." AND ques_id = ".$this->quesid;
						break;
					}
					
					case  "edit" :
					{
						$this->qvalues['operation'] = 'save';
						$ret_value = $this->get_file_contents('multichoice.php');
						break;
					}					
				}
				break;
			} //eof multiplechoice
//The following case-select block added by SMQ to handle the creation/editing of a written question - SMQ
		case DESCRIPTION : 
			{
				switch ($oper) {
				
					case  "add" :
					{
						$this->qvalues['operation'] = 'addresp';
						$ret_value = $this->get_file_contents('written.php');
						break;
					}
					
					case "addresp" :
					{
						$ret_value = "INSERT INTO ". QUESTIONS_TABLE . " (cat_id, course_id, ques_name, stem, media_name, points, feedback, qtype, createdby, lastedited_by, lastedited_date) 
										VALUES (".$this -> ca.",".$this -> cid.",'".$this->qvalues['qname']."','".$this->qvalues['qstem']."','"
													.$this->qvalues['media_name']."', '".$this->qvalues['points']."', '".$this->qvalues['feedback']."', '2', ".$this->userid.",".$this->userid.",".time().")";
						break;
					}
					
					case "save" :
					{
						$ret_value = "UPDATE ". QUESTIONS_TABLE ." SET 
										ques_name = '".$this->qvalues['qname']. "', stem = '".$this->qvalues['qstem']."', media_name = '".$this->qvalues['media_name']."', feedback = '".$this->qvalues['feedback']."', lastedited_by = ".$this->userid." , lastedited_date = ".time()." ,
									   points = '".$this->qvalues['points']. "' WHERE question_id = ".$this->quesid;
						break;
					}
					case "save_pnts" :
					{
						$ret_value = "UPDATE ". QUIZ_QUESTIONS_TABLE ." SET 
										lastedited_by = ".$this->userid.", lastedited_date = ".time()." ,
									   points = '".$this->qvalues['points']. "' WHERE quiz_id = ".$this->qzid." AND ques_id = ".$this->quesid;
						break;
					}
					
					case  "edit" :
					{
						$this->qvalues['operation'] = 'save';
						$ret_value = $this->get_file_contents('written.php');
						break;
					}					
				}
				break;
			} //eof written
		}
		return $ret_value;
	
	} //eof operation
	function get_file_contents($file_name) {
						
		ob_start();
			require($file_name);
			$buffer = trim(ob_get_contents());
		ob_end_clean();					
		$ret =  $this->evalHTML($buffer);
		return $ret;	
	} //eof get file contents
	
	function evalHTML($string)	 {
		$pos = 0;
		$start = 0;
		
		while (($pos = strpos ($string, '<?php', $start)) != FALSE) {
			$pos2 = strpos ($string, "?>", $pos+5);
			ob_start();
				eval( substr( $string, $pos+5, $pos2-$pos-5) );
				$value = ob_get_contents();
			ob_end_clean();
		
			$start = $pos + strlen($value);
			$string = substr ($string, 0, pos) . $value . substr ($string, $pos2+2);
		}
		return $string;
	} // eof evalHTML
 }//eof class
?>