<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<title>Homework 11 Example</title>
		<!--Jquery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

		<script type="text/javascript">
        var updateCounter = 0;
        function AjaxPost_Construct(constructionType,passwordVar,commentVar,authorVar,cid,statusVar){
            alert('here');
            passwordVar = typeof passwordVar  !== 'undefined' ? passwordVar  : '';
            commentVar = typeof commentVar !== 'undefined' ? commentVar : '';
            authorVar = typeof authorVar !== 'undefined' ? authorVar : '';
            cid = typeof cid !== 'undefined' ? cid : '';
            statusVar = typeof statusVar !== 'undefined' ? statusVar : '';

            $.post("ajaxHomework10.php",{
                            constructiontype: constructionType,
                            password: passwordVar,
                            comment:commentVar,
                            author: authorVar,
                            commentid: cid,
                            status: statusVar},
                function(data, status){
                    if(constructionType == 'editlist'){
                        $('#divEditList').html(data);
                    }else if(constructionType == 'inputbox'){
                        $('#divInputBox').html(data);
                    }else if(constructionType == 'displaylist'){
                        $('#divDisplayList').html(data);
                    }else if(constructionType == 'editbox'){
                        $('#divEditBox').html(data);
                    }else if(constructionType == 'submitcomment'){
                        $('#divEditBox').html(data);
                    }else if(constructionType == 'update'){
                        updateCounter = updateCounter - 1;
                        if(updateCounter == 0){
                            HideDisplayList();
                            ShowDisplayList();
                        }
                    }
            });
        }
</script>


		<!--						-->
		<!--Jquery to modify html 	-->
		<!--						-->
		<script type="text/javascript">
		function ShowEditList(){	AjaxPost_Construct('editlist');}
		function HideEditList(){	$('#divEditList').html('');}
		function ShowDisplayList(){	AjaxPost_Construct('displaylist');}
		function HideDisplayList(){	$('#divDisplayList').html('');}
		function ShowInputBox(){	AjaxPost_Construct('inputbox');}
		function HideInputBox(){	$('#divInputBox').html('');}
		function ShowEditBox(){		AjaxPost_Construct('editbox');}
		function HideEditBox(){		$('#divEditBox').html('');}
		</script>

		<!--						-->
		<!--Jquery to change DB 	-->
		<!--						-->
		<script type="text/javascript">
		function SubmitNewComment(){
			AjaxPost_Construct('submitcomment','',GetNewComment(),GetNewAuthor());
		}
		function GetNewAuthor(){
			return $('#txtNewAuthor').val();
		}
		function GetNewComment(){
			return $('#textareaComment').val();
		}
		function GetEditPassword(){
			return $('#passwordEdit').val();
		}
		function UpdateComments(){
			return $('#divEditItem').each(function() {
				updateCounter = updateCounter + 1;
				var commentID = $(this).attr('commentid');
				var author = $(this).find('.txtEditAuthor').val();
				var comment = $(this).find('.textareaEditComment').val();
				var statusType = $(this).find('input:radio').prop("checked");
				var status;
				if(statusType){
					status = 1;
				}else{
					status = 0;
				}
				AjaxPost_Construct('update','',comment,author,commentID, status);
			});
		}
		</script>

		<!--						-->
		<!--Jquery ready function 	-->
		<!--						-->
		<script type="text/javascript">
		$(document).ready(function (){
			ShowInputBox;
			ShowEditBox;
			ShowDisplayBox;

			$('body').on('click','#btnCancelEdit', function(e){
				e.preventDefault();
				HideEditList();
				ShowDisplayList();
				ShowInputBox();
				ShowEditBox();
			});
			$('body').on('click','#btnSubmit', function(e){
				e.preventDefault();
				SubmitNewComment();
				HideInputBox();
				ShowInputBox();
				ShowEditBox();
			});
			$('body').on('click','#btnEdit', function(e){
				e.preventDefault();
				HideEditBox();
				HideDisplayList();
				HideInputBox();
				ShowEditList();
			});
			$('body').on('click','#btnSaveEdit', function(e){
				e.preventDefault();
				UpdateComments();
				HideEditList();
				ShowDisplayList();
				ShowInputBox();
				ShowEditBox();
			});
		});
		</script>

		<!--						-->
		<!-- 		CSS				-->
		<!--						-->
		<style type="text/css">
		button{width:100%;}
		.basicLabel{/*width:30%*/float:left;}
		textarea{resize: none; overflow: hidden;}
		hr.commentbreak{color: #708090; size:10px;}
		table{width:100%;}

		#divCommentControl{width:50%; border: 2px solid #000000;}
		#divCommentControl #divInnerComment{margin: 5% 5% 5% 5%;}
		#divCommentControl #divInnerComment #divInputBox{width: 100%;}
		#divCommentControl #divInnerComment #divInputBox #textareaComment{width: 100%;}
		#divCommentControl #divInnerComment #divInputBox #txtNewAuthor{width: 100%; margin-right:1%;}

		#divCommentControl #divInnerComment #divEditBox{width:100%;}
		#divCommentControl #divInnerComment #divEditBox #passwordEdit{width:100%; margin-right:1%;}

		#divCommentControl #divInnerComment #divEditList .divEditItem .txtEditAuthor{width:100%;}
		#divCommentControl #divInnerComment #divEditList .divEditItem .textareaEditComment{width:100%;}
		#divCommentControl #divInnerComment #divEditList .divEditItem .divEditStatus .divRadio {}

		#divCommentControl #divInnerComment #divDisplayList .divDisplayItem {width: 100%; float: left;}
		#divCommentControl #divInnerComment #divDisplayList .divDisplayItem .pCommentText {width: 100%;}
		#divCommentControl #divInnerComment #divDisplayList .divDisplayItem .divAuthorName {float: right;}

		.wordwrap {
			white-space: pre-wrap;
			white-space: -moz-pre-wrap;
			white-space: -pre-wrap;
			white-space: -o-pre-wrap;
			word-wrap: break-word;
		}
		</style>
	</head>
	<body>
	<div id='divCommentControl'>
		<div id="divInnerComment">
			<h3 id = "h3CommentTitle">Comments</h3>
			<div id = "divInputBox"></div>
			<hr class="hrSeperator" />
			<div id = "divEditBox"></div>
			<hr class="hrSeperator" />
			<div id = "divEditList"></div>
			<div id="divDisplayList"></div>
		</div>
	</div>
	</body>
</html>
