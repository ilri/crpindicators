<?php
function initialCap($val)
{
	$str = explode(" ",$val);
	$len = count($str);
	$i=$len;
	$strn="";
	$j=0;
	while($i>0)
	{
		$strn.=strtoupper(substr($str[$j],0,1))."".strtolower(substr($str[$j],1))." ";
		$j++;
		$i--;
	}
	return $strn;
}

function formatNouns($val)
{
	$str = explode(" ",$val);
	$len = count($str);
	$i=$len;
	$strn="";
	$j=0;
	while($i>0)
	{
		$strn.=strtoupper(substr($str[$j],0,1))."".strtolower(substr($str[$j],1))." ";
		$j++;
		$i--;
	}
	return $strn;
}

function formatNumber($num)
{
	$ext = explode(".",$num);
	if(empty($ext[1]))
		return number_format($num,2,'.',',');
	else
		return number_format($num,2,'.',',');
	return $num;
}

function getMonth($month){
	if(!empty($month))
		return date('M', mktime(0, 0, 0, $month, 1, 2000));
}

function getDates($year,$month,$date){
	return mktime(0, 0, 0,  date("Y",$year),date("m",$month)  , date("d",$date));
}

function formatNumbertoZero($num)
{
	$ext = explode(".",$num);
	 if(empty($ext[1]))
		return number_format($num,2,'.',',');
	else
		return number_format($num,2,'.',',');
	return $num;
}

function formatDate($date)
{
	if(!empty($date) && $date!=="0000-00-00")
		return date("d M Y",strtotime($date));
}

function showError($error)
{
	if(!empty($error))
	{
	?>
    <script type="text/javascript">        
	alert("<?php echo $error; ?>");
	</script>
    <?
	}
}
function logging($str){
	$fd=fopen("data.log","a");
	fwrite($fd,$str."\n");
	fclose($fd);
}
function redirect($url,$new=""){
?><HEAD>
		<SCRIPT language="JavaScript1.1">
			<!--
				location.replace("<? echo $url ?>");
			//-->
		</SCRIPT>
	</HEAD>
<?		  
}
function firstThree($str){
	$st=explode(' ',$str);
	for($i=0;$i<count($st);$i++){
		$s.=substr($st[$i],0,3)." ";
	}
	return $s;
}

function addTime($time,$minutes){
	$date = date("H:i", strtotime('+ '.$minutes.' minutes',strtotime($time)));
	return $date;
}
function addDate($date,$days){
	$date = date('Y-m-d',strtotime($date . "+".$days." days"));
	return $date;
}

function sendMail($to,$subject,$message) {
	$from = "jgatheru@wisedigits.com";
	$headers = "From:" . $from;
	if(mail($to,$subject,$message,$headers))
		echo "Mail Sent.";
	else
		echo "Mail not Sent.";
}

function auth($auth)
{
	$auth->roleid=$auth->roleid;
	$auth->levelid=$auth->levelid;
	if(!existsRule($auth))
	{
		$levelerror=1;
		redirect("../../../modules/auth/users/login.php?levelerror=".$levelerror);
	}
}


function modularAuth($moduleid,$levelid){
	$query="select * from auth_rules where roleid in (select id from auth_roles where moduleid='$moduleid') and levelid='$levelid'";
	mysql_query($query);
	if(mysql_affected_rows()>0)
	  return true;
	else
	  return false;
}

function existsRule($auth){

// 	$rules=new Rules ();
// 	$fields=" * " ;
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$where=" where roleid='$auth->roleid' and levelid='$auth->levelid'";
// 	$rules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if($rules->affectedRows>0)
// 		return true;
// 	else
// 		return true;

return true;

}

function checkRule($id,$tablename){
  $query="select * from crp_$tablename where id='$id' and userid='".$_SESSION['userid']."'";
  mysql_query($query);
  if(mysql_affected_rows()>0)
    return true;
  else
    return false;
}

function checkGroup($module, $bool=""){
  $tbl = mysql_fetch_object(mysql_query("select * from crp_tables where name='$module' and status='Open'"));
  //$query="select * from crp_groupmodule where tableid='$tbl->id' and groupid in(select group_id from crp_usergroup where user_id='".$_SESSION['userid']."')";
  //mysql_query($query);
  //if(mysql_affected_rows()>0){
    $sql="select * from crp_crptables where crp_crptables.tableid='$tbl->id' and crp_crptables.crpid='".$_SESSION['crpid']."'";
    mysql_query($sql);
    if(mysql_affected_rows()>0)
      return true;
    else
      return false;
 // }
  //else
    //return false;
}

function supervisor($id){
  $query="select * from crp_crpuser where userid='".$_SESSION['userid']."' and supervisor=1 and crp_id='".$_SESSION['crpid']."' and valid_data in('',0)";
  mysql_query($query);
  if(mysql_affected_rows()>0)
    return true;
  else
    return false;
}

function getRecords($table){

  $ind = mysql_fetch_object(mysql_query("select * from crp_tables where name='$table'"));
  
  echo "($ind->indicator)";
  
  $query="select (select count(*) from crp_$table where valid_data in('',0) and crpid='".$_SESSION['crpid']."' and rec_period='".$_SESSION['rec_period']."') cnt1, (select count(*) from crp_$table where crpid='".$_SESSION['crpid']."' and rec_period='".$_SESSION['rec_period']."') cnt2";//echo $query;
  $row=mysql_fetch_object(mysql_query($query));
  
  $qr="select * from crp_crpuser where userid='".$_SESSION['userid']."' and crp_id='".$_SESSION['crpid']."' and supervisor='1'";
  mysql_query($qr);
  if(mysql_affected_rows()>0){
    echo " <br/><font size='0.1'> ";
  
    if($row->cnt1>0){
      echo " <font  color='green'>".$row->cnt1." New ";
      if($row->cnt1==1)
	echo "Entry";
      else
	echo "Entries";
      echo ".</font></font>";
      echo " <a href='approve.php?tbl=".$table."'><font color='red'>Approve All ".$row->cnt1."</font></a>";
    }
  }
}

function img_resize( $tmpname, $size, $save_dir, $save_name )
{
	$save_dir .= ( substr($save_dir,-1) != "/") ? "/" : "";
	$gis       = GetImageSize($tmpname);
	$type       = $gis[2];
	switch($type)
	{
		case "1": $imorig = imagecreatefromgif($tmpname); break;
		case "2": $imorig = imagecreatefromjpeg($tmpname);break;
		case "3": $imorig = imagecreatefrompng($tmpname); break;
		default:  $imorig = imagecreatefromjpeg($tmpname);
	}

	$x = imageSX($imorig);
	$y = imageSY($imorig);
	if($gis[0] <= $size)
	{
		$av = $x;
		$ah = $y;
	}
	else
	{
		$yc = $y*1.3333333;
		$d = $x>$yc?$x:$yc;
		$c = $d>$size ? $size/$d : $size;
		$av = $x*$c;        //высота исходной картинки
		$ah = $y*$c;        //длина исходной картинки
	}
	$im = imagecreate($av, $ah);
	$im = imagecreatetruecolor($av,$ah);
	if (imagecopyresampled($im,$imorig , 0,0,0,0,$av,$ah,$x,$y))
		if (imagejpeg($im, $save_dir.$save_name)) {
		echo"Success\n";
		return true;
	}
	else {
		echo"Failure\n";
		return false;
	}
}
function sendNotification($email,$name,$subject,$body){
  include("../../../class.phpmailer.php");
  include("../../../class.smtp.php");
  
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port

  $mail->Username   = "mujoga@gmail.com";  // GMAIL username
  $mail->Password   = "josemariaescriva";            // GMAIL password

  $mail->From       = "replyto@yourdomain.com";
  $mail->FromName   = "CRP Indicators";
  $mail->Subject    = $subject;
  $mail->AltBody    = ""; //Text Body
  $mail->WordWrap   = 50; // set word wrap
  
  $mail->MsgHTML($body);
  
  $body .= file_get_contents('mail.html');
  
  $mail->AddAddress($email,$name);

  $mail->IsHTML(true); // send as HTML

  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Message has been sent";
  }
}
function retrieveTables($page_title){
  require_once("../tables/Tables_class.php"); 
  $tables = new Tables();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where name='".strtolower($page_title)."'";
  $tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $tables = $tables->fetchObject;
  return $tables;
}

function getCrpAttribution($obj){
  
  //retrieve from indcrpalloc  
  $query="select crp_crps.crp_name crpid, indcrpalloc.alloc from indcrpalloc left join crp_crps on crp_crps.id=indcrpalloc.crpsid where tableid='$obj->tableid' and valueid='$obj->id'";
  $res = mysql_query($query);
  $arr="";
  while($row=mysql_fetch_object($res)){
    $arr.=$row->crpid."(".$row->alloc."%)<br/>";
  }
  return $arr;
}

function getThemes($obj){

  //retrieve from indthmalloc  
  $query="select crp_themes.name crpid, indthmalloc.alloc from indthmalloc left join crp_themes on crp_themes.id=indthmalloc.themeid where tableid='$obj->tableid' and valueid='$obj->id'";
  $res = mysql_query($query);
  $arr="";
  while($row=mysql_fetch_object($res)){
    $arr.=$row->crpid."<br/>";
  }
  return $arr;
  
}

function getValueChains($obj){

  //retrieve from indthmalloc  
  $query="select crp_valuechains.name crpid, indvlcalloc.alloc from indvlcalloc left join crp_valuechains on crp_valuechains.id=indvlcalloc.valuechainid where tableid='$obj->tableid' and valueid='$obj->id'";
  $res = mysql_query($query);
  $arr="";
  while($row=mysql_fetch_object($res)){
    $arr.=$row->crpid."<br/>";
  }
  return $arr;
  
}

function validateCRPAttribution($obj){
  require_once("../../crp/crps/Crps_class.php");
  $crps = new Crps();
  $fields="*";
  $where="";
  $groupby="";
  $having="";
  $orderby="";
  $crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $array=array();
  $aRow = (array)$obj;
  $total=0;
  while($row=mysql_fetch_object($crps->result)){
    $id=$row->id;
    $total += $aRow[$id];
  }
  if($total>100){
    $error="Incorrect percentages for % Attribution";
  }
  return $error;
}
?>