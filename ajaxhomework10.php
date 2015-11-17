<?php

	//echo 'starting php now';

	$username = 'njurden';
	$password = 'Password123!';


	//	PHP SETUP ROOT PATH

	//echo "setup root"
	$mRootpath = "";
	$mFilepath = explode('/', dirname(__DIR__));
	foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f== "public_html"){break;}}
	define('ROOT_PATH', $mRootpath);

	//PHP ERROR REPORTING
	//echo "error reporting"
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//PHP DATABASE CONNECTION
	$database = @mysql_connect('mysql.eecs.ku.edu', $username, $password);
	if(!$database) {
		die('Could not connect: ' . mysql_error());
	}
	if(!mysql_select_db($username, $database)) {
		die('Could not select database: ' . mysql_error());
	}

	//recieve all variables from ajax call
	$constructionType 	= $_POST['constructionType'];
	$password 					= $_POST['password'];
	$comment 						= $_POST['comment'];
	$author							= $_POST['author'];
	$commentID 					= $_POST['commentid'];
	$status 						= $_POST['status'];
	//echo "variables received"
	//database query functions
	function QueryGetAllComments($database){
		$sqlQuery = "SELECT * FROM USERCOMMENTS";
		return mysql_query($sqlQuery, $database);
	//	echo "comments"
	}
	function QuerySubmitNewComment($author, $comment, $database){
		$sqlQuery = 'INSERT INTO USERCOMMENTS(AUTHOR, COMMENT) VALUES("'.mysql_real_escape_string($author).'","'.mysql_real_escape_string($comment).'")';
		mysql_query($sqlQuery);
	//	echo "submitted"
	}
	function QueryUpdateComment($commentID, $author, $comment, $status, $database){
		$sqlQuery = 'UPDATE USERCOMMENTS SET AUTHOR="'.mysql_real_escape_string($author).'", COMMENT="'.mysql_real_escape_string($comment);
		$sqlQuery .= '",STATUS='.$status.' WHERE COMMENTID =' .$commentID;
		if(!mysql_query($sqlQuery)){
			echo "ERROR!";}
	//	echo "update"
	}

	//functions to construct html objects
	function ConstructEditBox(){
		echo '<table>';
		echo '<tr>';
		echo '	<td style="width:24%;"><label>Edit Password:</label></td>';
		echo '	<td style="width:36%;"><input type="password" id="passwordEdit" /></td>';
		echo '	<td><button id="btnEdit">Edit</button></td>';
		echo '</tr>';
		echo '</table>';
	}

	function ConstructEditItem($commentID, $author, $comment, $active){
	echo '<div class="divEditItem" commentid="'.$commentID.'">';
	echo '<table>';
	echo '	<tr>';
	echo '		<td style="width:24%"><label>Author:</label></td>';
	echo '		<td colspan="2"><input type="text" class="txtEditAuthor" value="'.$author.'" /></td>';
	echo '	</tr>	';
	echo '	<tr>';
	echo '		<td style="width:24%"><label>Comment:</label></td>';
	echo '		<td colspan="2"><textarea class="textareaEditComment">'.$comment.'</textarea></td>';
	echo '	</tr>	';
	echo '	<tr>';
	echo '		<td style="width:24%"><label>Status:</label></td>';
	echo '		<td><input type="radio" name="status'.$commentID.'" value="visible" '.(($active == 1) ? 'checked="checked"' : '').' />Active (Visible)</td>';
	echo '		<td><input type="radio" name="status'.$commentID.'" value="hidden" '.(($active == 0) ? 'checked="checked"' : '').' />Inactive (Hidden)</td>';
	echo '	</tr>';
	echo '	<tr><td colspan="3"></td></tr>';
	echo '</table><br clear "all" />';
	echo '</div>';
	}

	function ConstructEditList($database){
		$result = QueryGetAllComments($database);
		while($row = mysql_fetch_array($result)){
			ConstructEditItem($row['COMMENTID'],$row['AUTHOR'], $row['COMMENT'], $row['STATUS']);
		}
		echo '<table>';
		echo '<tr><td></td><td><button id="btnCancelEdit">Cancel</button></td><td><button id="btnSaveEdit">Save</button></td></tr>';
		echo '</table>';
	}

	function ConstructDisplayList($databse){
		$result = QueryGetAllComments($databse);
		while($row = mysql_fetch_array($result)){
			if($row=['STATUS'] == 1){
				ConstructDisplayItem($row['AUTHOR'], $row['COMMENT']);
			}
		}
	}

	function ConstructDisplayItem($author, $comment){
		echo '<div class="divDisplayItem">';
		echo '	<p class="pCommentText wordwrap">'.$comment.'</p>';
		echo '	<div class="divAuthorName">- '.$author.'</div>';
		echo '</div>';
		echo '<br clear="all"/>';
	}

	function ConstructInputBox(){
		echo '<table>';
		echo '<tr><td colspan="3"><textarea id="textareaComment"></textarea></td></tr>';
		echo '<tr>';
		echo '<td style="width:24%;"><label>Author Name:</label></td>';
		echo '<td style="width:36%;"><input type="text" id="txtNewAuthor" /></td>	';
		echo '<td><button id="btnSubmit">Submit</button></td>';
		echo '</tr>';
		echo '</table>';
	}

	//logic - always run
	if($constructionType == 'editbox'){
		ConstructEditBox();
	}else if($constructionType == 'inputbox'){
		ConstructInputBox();
	}else if($constructionType == 'editlist'){
		ConstructEditList($database);
	}else if($constructionType == 'displaylist'){
		ConstructDisplayList($database);
	}else if($constructionType == 'submitcomment'){
	 	QuerySubmitNewComment($author, $comment, $database);
	}else if($constructionType == 'update'){
		QueryUpdateComment($commentID, $author, $comment, $status, $database);
	}

	//close databse connection
	mysql_close($database);

	//echo 'stopping php now';
?>
