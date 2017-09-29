<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Refresh" content="3; URL=risk.php">
</head>
<body><center>
<h1>
<?php

include "connect.php";
try {
	$ins = $conn->prepare("update sme_hooks.risk_loader
	set uptime = sysdate,
	    attachment = EMPTY_BLOB()
	where ftype = 'S' RETURNING ATTACHMENT into :atatch");

	$ins -> bindParam(':atatch', $atatch, PDO::PARAM_LOB);
	$atatch = fopen($_FILES['str_file']['tmp_name'], 'rb');
	$conn->beginTransaction();
	$ins->execute();
	$conn->commit();
} catch(PDOException $e) {
	echo $e->getMessage();

}
$ins = null;
$ins = $conn->prepare("select sys_ip, server from sme.connections c left join sme_hooks.risk_servers s on c.sys_ip=s.server");
$ins->execute();
$ins->bindColumn(1, $name, PDO::PARAM_STR, 50);

while ($row = $ins->fetch()) {
	if ($row["SERVER"]) {
		$inr = $conn->query("update sme_hooks.risk_servers set chdate = sysdate, res=0 where server='".$row["SERVER"]."'");
	} else {
		$inr = $conn->query("insert into sme_hooks.risk_servers VALUES ('".$row["SYS_IP"]."', 'S', sysdate, 0)");
	}	
}

echo "Стратегии загружены на сервера, ожидайте установки";

?>
</h1>
</center>
</body>
</html>