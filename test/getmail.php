<?php
class getmails{
	//const db_name = "gmail";
	//const tbl_name = "emails";
function __construct(){

	$con = mysql_connect("localhost","root","");
	if(!$con){
		mysql_error('Cant connect to mysql please check your server.');
	}
	$db = mysql_select_db('gmail',$con);
	if(!$db){
		mysql_error('Database not selecting please try again.');
	}
}

function loadGmailMails($from,$to){
    $hostname = '{imap.gmail.com:993/ssl/novalidate-cert}INBOX';
    $username = 'rajeshyogi28@gmail.com';
    $password = 'rajesh9694390857';
     
    $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
    $e = imap_search($inbox,'ALL');
 
    $emails = array();
 
    if($e) {
        rsort($e);//put the newest emails on top
         
        if($to == 0) $to = sizeof($e);
         
        for($i=$from;$i<$to;$i++){
            $overview = imap_fetch_overview($inbox,$e[$i],0);
			// echo '<pre>';
			// print_r($overview);
			
			foreach($overview as $key=>$allview){
			
				 $query = mysql_query("insert into emails (subject,mailfrom,mailto,mdate,message_id,size,uid,msgno,recent,flagged,answered,deleted,seen,draft,udate)values('$allview->subject','$allview->from','$allview->to','$allview->date','$allview->message_id','$allview->size','$allview->uid','$allview->msgno','$allview->recent','$allview->flagged','$allview->answered','$allview->deleted','$allview->seen','$allview->draft','$allview->udate')");
			}
			$message = imap_fetchbody($inbox,$e[$i],2);
             
            preg_match('/(?P<name>[a-zA-Z ]+)<(?P<address>.+)>/',$overview[0]->from,$match);
            trim($match['name']);
             
            $emails[] = array('read' => $overview[0]->seen, 'subject' => $overview[0]->subject, 'from' => array('name' => $match['name'], 'address' => $match['address']), 'date' => $overview[0]->date, 'message' => $message);
        }
    }
 
    imap_close($inbox);
     
    return $emails;
}

}
$obj = new getmails();
$obj->loadGmailMails(0,10);
?>

