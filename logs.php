<?php
include "settings.php";
include "connect.php";
if ($debug) { echo $_SERVER['QUERY_STRING']; }
$x = array();
if ($_POST['log_def']) {
	$x[0]=array('D');
}
if ($_POST['log_wrap']) {
	$x[1]=array('W');
}
//print_r($x);

//echo $z;
try {
	$ins = null;
	// Получаем список доступных серверов для загрузки логов
	foreach ($x as $z ) {
	print_r($z);
	echo "<br>";

	$sql = "select sys_ip, server, ltype from sme.connections c left join sme_hooks.risk_logs s on c.sys_ip=s.server and ltype='".$z[0]."'";
	echo $sql;
	echo "<br>";
	$ins = $conn->prepare($sql);
	$ins->execute();
	$ins->bindColumn(1, $name, PDO::PARAM_STR, 50);
	// Нам на вход могут запросить выгрузку нескольких логов, пытаемся сделать динамическую и логическую модель анализа

	while ($row = $ins->fetch()) {
		
		if ($row["SERVER"] || $row['LTYPE']) {
			$inr = $conn->query("update sme_hooks.risk_logs set chdate = sysdate, res=0, getm=".$_POST['getm']." where server='".$row["SERVER"]."' and ltype='".$z[0]."'");
			print_r($inr);
			echo "<br>";
		} else {
			$inr = $conn->query("insert into sme_hooks.risk_logs (server, ltype, chdate, res, getm) VALUES ('".$row["SYS_IP"]."', '".$z[0]."', sysdate, 0, ".$_POST['getm'].")");
			print_r($inr);
			echo "<br>";
		}
	}

	
	
	}
} catch(PDOException $e) {
	echo $e->getMessage();

}

/*
1. Записываем, какие логи нужны. По одной строчке для каждого лога и каждого сервера.
*/
?>
