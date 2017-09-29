<?php 
include "connect.php";
try {
	//Проверяем, что в бд есть обновление по стратегиям для данного сервера
	//Если есть, сохраняем файл на локальной машине в каталог UG
	//Формируем файл-флаг
	$flag = false;
	$req = $conn->query("select res from sme_hooks.risk_servers where otype='S' and lower(server) = lower('".$argv[1]."') and res=0");
	echo "Вот такой запрос отправляем в БД:
	";
	print_r($req);
	echo '
	';
	echo 'Список полученных значений из БД:
	';
	foreach ($req as $row) {
		print_r($row);
		if ($row["RES"] == 0) {

			$flag = true;
		}
	}
	echo 'Провека обновления и сохранение файла
	';
	if ($flag) { //Новые стратегии есть. Начинаем их ставить
		// Скачиваем на локальный диск файл стратегий
		$ins = $conn->prepare("select attachment from sme_hooks.risk_loader where ftype = 'S'");
		$ins->execute();
		$ins->bindColumn(1, $lob, PDO::PARAM_LOB);
		$ins->fetch(PDO::FETCH_BOUND);
		$f = fopen("strategy.zip", 'w');
		$flob = stream_get_contents($lob);
		fwrite($f, $flob);
		fclose($f);
		echo 'Стратегии выгружены на локальный диск\n';
		// Взводим флаг, что стратегии есть и можно начинать установку
		$fl = fopen('d:\transact\temp\copy_ready.flg', 'w');
		fclose($fl);
		//Метим запись в БД, что стратегии взяты в работу.
		$conn->query("update sme_hooks.risk_servers set res=1 where lower(server) = lower('".$argv[1]."')");		
	}
} catch (Exception $e) {
	echo "Обосрались";	
}
/*
$ins = $conn->prepare("select attachment from sme_hooks.risk_loader where ftype = 'S'");
$ins->execute();
//$ins -> bindParam(':atatch', $atatch, PDO::PARAM_LOB);
$ins->bindColumn(1, $lob, PDO::PARAM_LOB);
$ins->fetch(PDO::FETCH_BOUND);
//$atatch = fopen($_FILES['str_file']['tmp_name'], 'rb');
$f = fopen("strategy.zip", 'w');
$flob = stream_get_contents($lob);
fwrite($f, $flob);
fclose($f);
*/
?>