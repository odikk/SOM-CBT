<?phpdefine('IN_somCBT', true);$phpEx = 'php';$somCBT_root_path = './../';include($somCBT_root_path . 'common.php');$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;$quesid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;//// Start session management//$userdata = session_pagestart($user_ip, PAGE_QUIZ_CREATE);init_userprefs($userdata);//// End session managementif( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) {//FYI - Grabs selected question from DB, and if QUESTION tab is selected, pulls from question.php and is //handled there by the EDIT case-select section. From there it sources multichoice.php where it pulls the actual form field content - SMQ			if ( ($mode == 'view' ) &&( ( $userdata['user_level'] == ADMIN ) || ( in_array($cid, $course['teaches'] ) )) ){				$sql = "SELECT * FROM ".QUIZ_QUESTIONS_TABLE." WHERE question_id = ".$qid ." LIMIT 1";								if ( ($result = $db->sql_query($sql))) {													if ($row = $db->sql_fetchrow($result)) {											$template->assign_block_vars('hide_options',array());											$nav_path .= $row['ques_name'];											$question = new question();						$question -> setIDs($cid,$ca,$row['qtype'], $userdata['session_user_id'], $qid);												$question_values = array();						$question -> setValue($row);							$template->assign_block_vars('question',array('ACTION' => append_sid('question_points.php?ARG1='.$cid.'&ARG2='.$ca), 											'FORM_NAME' => 'questions',											'FORM_HIDDEN' => '<input type="hidden" name="ARG3" value="'.$qid.'">',											'CONTENTS' => $question -> operation('edit')										));					} // eof question				}// eof resultset			}// eof view			elseif ( ($mode == 'save' ) && ( ( $userdata['user_level'] == ADMIN ) || ( in_array($cid, $course['teaches'] ) )) ){				$question = new question();				$question -> setIDs($cid,$ca,$HTTP_POST_VARS['qtype'], $userdata['session_user_id'], $qid);									$question_values = array();				$question_values['qstem'] =  (isset($HTTP_POST_VARS['ques_stem']) ? $HTTP_POST_VARS['ques_stem'] : '') ;				$question_values['qname'] =  (isset($HTTP_POST_VARS['ques_name']) ? $HTTP_POST_VARS['ques_name'] : '') ;									$question_values['qch1'] =  (isset($HTTP_POST_VARS['ques_ch1']) ? $HTTP_POST_VARS['ques_ch1'] : '') ;				$question_values['qch2'] =  (isset($HTTP_POST_VARS['ques_ch2']) ? $HTTP_POST_VARS['ques_ch2'] : '') ;				$question_values['qch3'] =  (isset($HTTP_POST_VARS['ques_ch3']) ? $HTTP_POST_VARS['ques_ch3'] : '') ;				$question_values['qch4'] =  (isset($HTTP_POST_VARS['ques_ch4']) ? $HTTP_POST_VARS['ques_ch4'] : '') ;				$question_values['qch5'] =  (isset($HTTP_POST_VARS['ques_ch5']) ? $HTTP_POST_VARS['ques_ch5'] : '') ;				$question_values['media_name'] =  (isset($HTTP_POST_VARS['media_name']) ? $HTTP_POST_VARS['media_name'] : '') ;				$question_values['feedback'] =  (isset($HTTP_POST_VARS['feedback']) ? $HTTP_POST_VARS['feedback'] : '') ;				$question_values['points'] ='';								for ( $i=1; $i<6; $i++) {					$question_values['points'] .= (empty($HTTP_POST_VARS["point$i"]) ?  0 :($HTTP_POST_VARS["point$i"])) ."#";				}				$question_values['qtype'] =  (isset($HTTP_POST_VARS['qtype']) ? intval($HTTP_POST_VARS['qtype']) : 1) ;																																											$question -> setValue($question_values);									$sql = $question -> operation('save');									if ( !$db->sql_query($sql) )				{					$message = 'Error in Updating Question';				}				else {					$message = '&nbsp;&nbsp;Question has been Updated';				}				$template->assign_block_vars('hide_options',array());								$nav_path .= $question_values['qname'];				$template->assign_block_vars('question',array('ACTION' => '', 											'FORM_NAME' => 'questions',											'FORM_HIDDEN' => '',											'CONTENTS' => '<br><br><span class="catHead">'.$message.'</span>&nbsp;&nbsp;<a href="'.append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid).'" class="action" >Return</a><br><br>'										));				unset($question_values);								}// eof save