<?php
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];


//Create Directory if doesn't exist
if(!file_exists('uploads/'))
	mkdir('uploads/', 0757);
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
	mkdir($dirfile,0755);
	chmod( $dirfile,0755);
	if($_FILES["file"]["error"] > 0 )
	{ 	$result=$_FILES["file"]["error"];} //error from 1-4
	else
	{
		$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
	  if(file_exists($upfile))
	  {
	  	$result="5"; //The file has been uploaded.
	  }
	  else{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					//insert into media table
					$insert = "insert into media(mediaid, filename,username,type,path,description,title)".
							  "values(NULL,'". urlencode($_FILES["file"]["name"])."','$username','".$_FILES["file"]["type"]."', '$upfile','".$_POST['description']."','".$_POST['title']."')";
					$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
					chmod($upfile, 0644);
					
					//insert tags into tag table
					$tags=explode(",",$_POST['tags']);
					$num=count($tags);
					$media_row=mysql_fetch_row($queryresult);
					for($i=0;$i<$num;$i++) {
						$insert2="insert into tags(mediaid,tag)"."values('$media_row[3]','$tags[$i]')";
						$query2=mysql_query($insert2);
							or die("Insert into Tags error in media_upload_process.php " .mysql_error());
					}
					$result="0";
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	}
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
