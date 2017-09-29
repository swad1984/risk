echo . >> log.log
ECHO ------------------------------------  >> log.log
ECHO %DATE% - %TIME% - BEGIN LOG REQUESTING  >> log.log
ECHO ------------------------------------  >> log.log
REM Проверяем наличие запроса на логи
d:\transact\php\php.exe d:\Transact\wwwroot\risk\logs_check.php %computername% check >> log.log
REM Там же копируем файлы во временную директорию

if exist d:\transact\temp\tmp_logs\flag.flag (
@cscript logs_check.js
	)

if exist d:\transact\temp\tmp_logs\flag.flag (
d:\transact\php\php.exe d:\Transact\wwwroot\risk\logs_check.php %computername% send >> log.log
del d:\transact\temp\tmp_logs\flag.flag >> log.log
del d:\transact\temp\tmp_logs\%computername%.rar
)

