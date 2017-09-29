<!DOCTYPE html>
<html>
<head>
	<title>Стартовая страница - новые экранные формы</title>
	<meta charset="windows-1251">
	<META http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	
<style type="text/css">
	.bor { border-width: 1px; border-style: solid; }
</style>
</head>
<body>
<?php include "menu.php" ?>
<!--<div class="container-fluid">
	<div class="row">
		<form  enctype="multipart/form-data" method="post" action="risk_load.php">
		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="kodsubprod">Выберите файл стратегий</label>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">				
				<input  type="file" name="str_file" class="form-control" id="str_file" placeholder="Выберите файл стратегий">
			</div>

		<input  runat="server" type="submit" name="submit1" id="submit1" value="Загрузить стратегии">
		<button id="but"  value="XA-XA" />
		</form>
	</div>
</div>
<hr> -->
<div class="container-fluid">
	<div class="row">
		<form  enctype="multipart/form-data" method="post" action="strategy.php">
		<label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2" for="str_file">Выберите файл стратегий</label>
			<div class="cell col-xs-3 col-sm-3 col-md-3 col-lg-3 has-success">				
				<input  type="file" name="str_file" class="form-control" id="str_file">
			</div>

			<div class="cell col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<input type="submit" name="submit1" id="submit1" value="Загрузить стратегии" class=" btn btn-success">
		</div>
		<!-- <input  type="file" name="str_file" class="" id="str_file"> -->
		</form>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<br><br><br>
		Скачивание стратегий пока в разработке. Лучше не нажимать кнопки ниже.
		<br><br>
		<form method="post" action="logs.php">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Выберите необходимые логи и способ их получения:</div>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 bor">
		<!-- <label class="checkbox col-xs-2 col-sm-2 col-md-2 col-lg-2" for="log_F"> -->
			Логи:<br>
			<input  type="checkbox" name="log_def" class="" id="log_def">default.log<br>
			<input  type="checkbox" name="log_wrap" class="" id="log_wrap">wrapper.log
		<!-- </label> -->
		</div>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 bor">
		<!-- <label class="checkbox col-xs-2 col-sm-2 col-md-2 col-lg-2" for="log_F"> -->
			Получить:<br>
			<input  type="radio" name="getm" class="" id="getm_p" value="1">На&nbsp;почту<br>
			<input  type="radio" name="getm" class="" id="getm_l" value="2">По&nbsp;ссылке
		<!-- </label> -->
		</div>
		<div class="cell col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<input type="submit" name="submit" id="submit" value="Запрос логов" class=" btn btn-success">
		</div>
		</div>
		<!-- <input  type="file" name="str_file" class="" id="str_file"> -->
		</form>
	</div>
</div>
<?php
//echo $_SERVER["SERVER_NAME"];
?>
</body>
</html>
