<?php
include "connect.php";
if ($argv[2] == 'check') {
	echo "IT is check"."\r\n";
	$flag = false;
	// Формируем запрос в БД для проверки запроса логов
	$sql = "select * from sme_hooks.risk_logs where lower(server) = lower('".$argv[1]."') and res='0'";
	$req = $conn->query($sql);
	echo $sql."\r\n";
	// Проверяем, если необработанные запросы
	foreach ($req as $row) {
		//Запросы есть. Теперь надо запрошенный лог скопировать во временную директорию и там его запаковать.
		//Проверяем наличие директории и при необходимости создаем
		if (!is_dir('d:\transact\temp\tmp_logs')) {
			mkdir('d:\transact\temp\tmp_logs');
		}
		echo $row['LTYPE']."\r\n";
		if ($row['LTYPE']=='D') {
			$flag = true;		
			copy('d:\transact\logs\ug\default.log','d:\transact\temp\tmp_logs\default.log');
			echo 'I COPY def.log '."\r\n";
			$f = fopen('d:\transact\temp\tmp_logs\flag.flag', 'w');
			fclose($f);
		}
		if ($row['LTYPE']=='W') {
			$flag = true;		
			copy('d:\transact\logs\ug\wrapper.log','d:\transact\temp\tmp_logs\wrapper.log');
			echo 'I COPY wrap.log '."\r\n";
			$f = fopen('d:\transact\temp\tmp_logs\flag.flag', 'w');
			fclose($f);
		}
	}
	echo $flag."\r\n";
	if ($flag) {
		$sql = "update sme_hooks.risk_logs set res='1' where lower(server)=lower('".$argv[1]."') and res='0'";
		$upd = $conn->query($sql);
		echo $sql."\r\n";

	}
}
else {
	echo "IS NOT CHECK"."\r\n";
}

if ($argv[2] == 'send') {
	// В начале надо определить, как доставить логи...
	// Делаем выборку и смотрим на тип получения логов
	$sql = "select getm from sme_hooks.risk_logs where lower(server)=lower('".$argv[1]."')";
	$sel = $conn->query($sql);
	foreach ($sel as $key) {
		$tdl = $key['GETM'];
	}
	$fn = 'd:\transact\temp\tmp_logs\\'.$argv[1].'.rar';
	if ($tdl == 2) {
		// Для формирования ссылок
		$ins = $conn->query("insert into sme_hooks.risk_logs (server, ltype, chdate, res, getm) VALUES ('".$argv[1]."', R, sysdate,0,1)");
		$ins = $conn->prepare("update sme_hooks.risk_logs
		set chdate = sysdate,
		    attach = EMPTY_BLOB()
		where ltype = 'R' and server='"+$argv[1]+"' RETURNING ATTACHMENT into :atatch");
		$ins -> bindParam(':atatch', $atatch, PDO::PARAM_LOB);
		
		$atatch = fopen($fn, 'rb');
		$conn->beginTransaction();
		$ins->execute();
		$conn->commit();
	} 
	if ($tdl == 1) {
		try {
		$mail = $conn->prepare("INSERT INTO SME_HOOKS.emails_queue (MESSAGE_ID,RECIPIENT_ADDRES,SUBJECT,TEXT,ATTACHMENT,MSG_STATUS,STORE_MSG_DATE,SESSION_ID,ATTACHMENT_FILENAME) 
							VALUES (sme_hooks.seq_emails_queue.nextval
									, :email
								    , :subj
								    , :temai
								    , EMPTY_BLOB()
								    , 0
								    , SYSDATE
								    , 0
								    , :fname ) RETURNING ATTACHMENT into :atatch ");

		$mail -> bindParam(':email', $email);
		$mail -> bindParam(':subj', $subj);
		$mail -> bindParam(':temai', $temai);

		$mail -> bindParam(':atatch', $atatch, PDO::PARAM_LOB);
		$atatch = fopen($fn, 'rb');
		$mail -> bindParam(':fname', $fname);
		//$fname = $_FILES['str_file']['name'];

		//$email = 'Rychazhkov-AI@mail.ca.sbrf.ru;';
		$email = 'Ehanurova-EN@mail.ca.sbrf.ru;';
		//transactsm-sme@mail.ca.sbrf.ru;Ehanurova-EN@mail.ca.sbrf.ru;Kashin-IA@mail.ca.sbrf.ru;
		$subj = 'Логи со стенда '.$stend;
		$fname = $argv[1].'.rar';		
		$temai = 'Добрый день!
Запрошенные логи во вложении с сервера '.$argv[1].'
'.date("G:i:s d.m.Y").'
_______________
С уважением,
АС TransactSM СМП
';


		$conn->beginTransaction();
		$mail->execute();
		$conn->commit();
		echo "Результат отправки сообщения
		";
		print_r($mail->errorInfo());
		//$conn->query("update sme_hooks.risk_servers set res=2 where lower(server) = lower('".$argv[1]."')");
		
		$conn->query("update sme_hooks.risk_logs set res='2' where lower(server)=lower('".$argv[1]."') and res='1'");
	}
	 catch (PDOException $e) {
		echo $e->getMessage();
	}		
	}

}
echo $argv[1]."\r\n";
echo $argv[2]."\r\n";
// Если запросы есть $flag стал true, то формируем файл-флаг
// 
//После запаковки, надо отправить лог письмом(если лог меньше 10Мб???, либо перебросить лог на КИшный сервер и сформировать ссылку для скачивания)
?>