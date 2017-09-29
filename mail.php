<?php

include "connect.php";

try {
	$mail = $conn->prepare("INSERT INTO SME_HOOKS.emails_queue (MESSAGE_ID,RECIPIENT_ADDRES,SUBJECT,TEXT,ATTACHMENT,MSG_STATUS,STORE_MSG_DATE,SESSION_ID,ATTACHMENT_FILENAME) 
						VALUES (sme_hooks.seq_emails_queue.nextval
								, :email
							    , :subj
							    , :temai
							    , null /*EMPTY_BLOB()*/
							    , 0
							    , SYSDATE
							    , 0
							    , null /*:fname*/ ) /*RETURNING ATTACHMENT into :atatch */");

	$mail -> bindParam(':email', $email);
	$mail -> bindParam(':subj', $subj);
	$mail -> bindParam(':temai', $temai);

	//$mail -> bindParam(':atatch', $atatch, PDO::PARAM_LOB);
	//$atatch = fopen($_FILES['str_file']['tmp_name'], 'rb');
	//$mail -> bindParam(':fname', $fname);
	//$fname = $_FILES['str_file']['name'];

	$email = 'Rychazhkov-AI@mail.ca.sbrf.ru;Ehanurova-EN@mail.ca.sbrf.ru;transactsm-sme@mail.ca.sbrf.ru;Kashin-IA@mail.ca.sbrf.ru;';
	//transactsm-sme@mail.ca.sbrf.ru;Ehanurova-EN@mail.ca.sbrf.ru;Kashin-IA@mail.ca.sbrf.ru;
	$subj = 'Óñòàíîâêà ñòðàòåãèé íà '.$stend;
	$temai = 'Äîáðûé äåíü!
Óñòàíîâêà ñòðàòåãèé íà ñòåíä '.$stend.', ñåðâåð '.$argv[1].', âûïîëíåíà óñïåøíî

_______________
Ñ óâàæåíèåì,
ÀÑ TransactSM ÑÌÏ

';
	echo "first test";
	$conn->beginTransaction();
	$mail->execute();
	$conn->commit();
	echo "Ðåçóëüòàò îòïðàâêè ñîîáùåíèÿ
	";
	print_r($mail->errorInfo());
	$conn->query("update sme_hooks.risk_servers set res=2 where lower(server) = lower('".$argv[1]."')");
} catch (PDOException $e) {
	echo $e->getMessage();
}

?>
