<?php//The following function added by SMQ to list all images in the ../images/symbols/ directory. The list will be placed into an array and //used to build the symbol gallery table - SMQfunction dirList ($directory) {    // create an array to hold directory list    $results = array();    // create a handler for the directory    $handler = opendir($directory);    // keep going until all files in directory have been read    while ($file = readdir($handler)) {        // if $file isn't this directory or its parent,         // add it to the results array        if ($file != '.' && $file != '..')            $results[] = $file;    }    // tidy up: close the handler    closedir($handler);    // done!    return $results;}?><table width="100%"  cellpadding="5" cellspacing="0" border="0" align="left"><tr><?php if ($this->lock =='n') { ?>	<td class="gen" align="left" valign="middle" width="100">Title</td>	<td class="gen" align="left" valign="middle"><input type="text" name="ques_name" value="<?php echo $this->qvalues['ques_name'];?>"></td><?php } ?>	<td class="gen" align="left" valign="middle"><img src="./../templates/default/images/sym_gall.gif" border="0" alt="symbols">		<table border="1">			<tr><?php//following PHP block added by SMQ to create the table matrix that lists the images for special entities (symbols) that can be//selected and inserted into the test question - SMQ		$imglist = dirList("./../templates/default/images/symbols/");//call function to read directory contents and write to array - SMQ		$imgcnt = count($imglist);		$imgdir = "./../templates/default/images/symbols/";		for ($i=0; $i<$imgcnt; $i++) 		{			$writestr = $imgdir.$imglist[$i];//loop through each item in directory array (i.e. each file in directory) and build 8 X ? table - SMQ			$nr=$i+1;			if(($nr % 8)==0) 			{?>				<td><a href="javascript:void(0);" onClick="insertatcursor('<img src=&quot;<?php print($writestr);?>&quot; alt=&quot;&quot; align=&quot;bottom&quot; border=0>')"><img src="<?php echo $imgdir.$imglist[$i];?>" alt="" align="bottom" border=0></a></td>				</tr>				<tr><?php			}else{?>				<td><a href="javascript:void(0);" onClick="insertatcursor('<img src=&quot;<?php print($writestr);?>&quot; alt=&quot;&quot; align=&quot;bottom&quot; border=0>')"><img src="<?php echo $imgdir.$imglist[$i];?>" alt="" align="bottom" border=0></a></td><?php			}		}?>			</tr>		</table>	</td> </tr><?php if ($this->lock =='n') { ?><tr>	<td class="gen" align="left" valign="top">Stem</td>	<td class="genmed" align="left" valign="middle">		<textarea name="ques_stem" rows="6" cols="60" onFocus="whoselected(document.questions.ques_stem)"><?php echo $this->qvalues['stem']; ?></textarea><br><br>		&nbsp;&nbsp;Image : <input type="text" name="media_name" value="<?php echo $this->qvalues['media_name']; ?>">&nbsp;&nbsp;&nbsp;		<a href="javascript:void(0);" class="action" onClick="javascript:popUp('<?php echo $this->file_browser ;?>',720,510,1,0)">&nbsp;Browse ...&nbsp;</a>	</td></tr><?php } ?><tr>	<td align="left" valign="middle" colspan="2" class="row1"><span class="bluebold11">Answers</span></td></tr><?php if ($this->lock =='n') { ?><tr>	<td class="gen" align="left" valign="top">Correct Response:</td>	<td class="gen" align="left" valign="middle"><textarea name="feedback" rows="20" cols="60" onFocus="whoselected(document.questions.feedback)"><?php echo $this->qvalues['feedback'];?></textarea></td></tr><?php } ?><tr>	<td class="gen" align="left" valign="middle"><td class="gensmall" align="left" valign="middle">Points :&nbsp;<input type="text" class="gensmall" name="point5" size="3" value="<?php echo $this->points[4]; ?>">      <input type="hidden" name="point1"><input type="hidden" name="point2"><input type="hidden" name="point3"><input type="hidden" name="point4"></td></tr><tr>	<td class="gen" align="left" valign="middle" colspan="2" height="35">		<a href="javascript:void(0);" onClick="javascript:submit_form(document.questions ,'<?php echo $this->qvalues['operation'];?>')" class="action">&nbsp;Save&nbsp;</a>&nbsp;&nbsp;		<?php			if ($this->qvalues['operation']!= 'addresp') { 			 //	echo '<a href="javascript:void(0);" onClick="return submit_form(document.questions ,\'del\')" class="action"> Delete</a>&nbsp;&nbsp;';			}		?>		<a href="javascript:void(0)" onClick="window.close()" class="action"> Cancel</a>	</td></tr><input type="hidden" name="action" value=""><input type="hidden" name="qtype" value="<?php echo $this->qtype ; ?>"><input type="hidden" name="ARG1" value="<?php echo $this->cid ; ?>"><input type="hidden" name="ARG2" value="<?php echo $this->ca ; ?>"><input type="hidden" name="ARG3" value="<?php echo $this->quesid ; ?>"><input type="hidden" name="QUIZ" value="<?php echo $this->qzid ; ?>"><input type="hidden" name="lck" value="<?php echo $this->lock ; ?>"></table>