echo . >> log.log
ECHO ------------------------------------  >> log.log
ECHO %DATE% - %TIME% - BEGIN CHECK STRATEGY  >> log.log
ECHO ------------------------------------  >> log.log

d:\transact\php\php.exe d:\Transact\wwwroot\risk\save_str.php %computername% >> log.log

if NOT exist d:\transact\temp\copy_ready.flg (
goto :eof
	)
REM Распаковываем стратегии в темп.директорию и тиражируем в каталог стратегий
REM unpack.cmd /Y >> log.log
mkdir d:\transact\temp\tmp_str >> log.log
move /Y d:\transact\wwwroot\risk\strategy.zip d:\transact\temp\tmp_str\ >> log.log
d:\transact\batch\winrar\winrar.exe e -afzip -y d:\transact\temp\tmp_str\strategy.zip d:\transact\temp\tmp_str\  >> log.log
del d:\transact\temp\tmp_str\strategy.zip  >> log.log
copy /Y d:\transact\temp\tmp_str\*.* d:\transact\ug\sm\*.*  >> log.log

REM Останавливаем службу UG
sc \\%computername%.ca.sbrf.ru stop OUG >> log.log
REM Ждем, пока служба UG остановится

set timer=0
:check_ug_down
set flag=true 
for /F "usebackq skip=3 tokens=4" %%a IN (`sc \\%computername%.ca.sbrf.ru query OUG`) DO if not "%%a"=="(0x0)" if not "%%a"=="(0x1)" if not "%%a"=="(0x42a)" if not "%%a"=="(0x42b)" if not "%%a"=="(0x435)" (
						if NOT "%%a" == "STOPPED" ( 
						set flag=false
						echo 1 - !flag!  >> log.log
						)
)
set /a timer=timer+1
REM echo 5 - !flag! 

if "%flag%" == "false" (
timeout /t 5
echo TRY NUMBER = %timer%  >> log.log
REM if /I "%timer%" LEQ "10" ( goto :check_ug )
if NOT "%timer%" == "40" ( goto :check_ug_down )
) 

REM Запускаем службу UG
sc \\%computername%.ca.sbrf.ru start OUG  >> log.log
REM Ожидаем полного запуска службы UG

set timer=0
:check_ug_up

set flag=true 
for /F "usebackq skip=3 tokens=4" %%a IN (`sc \\%computername%.ca.sbrf.ru query OUG`) DO if not "%%a"=="(0x0)" if not "%%a"=="(0x1)" if not "%%a"=="(0x42a)" if not "%%a"=="(0x42b)" if not "%%a"=="(0x435)" (
						if NOT "%%a" == "RUNNING" ( 
						set flag=false
						echo 2 - !flag!  >> log.log
						)
)
set /a timer=timer+1
REM echo 5 - !flag! 

if "%flag%" == "false" (
timeout /t 5
echo TRY NUMBER = %timer% >> log.log
REM if /I "%timer%" LEQ "10" ( goto :check_ug )
if NOT "%timer%" == "40" ( goto :check_ug_up )
) 

REM @cscript d:\transact\wwwroot\risk\mail.js
REM Формируем письмо об устпешной установке ??? Сделать проверку на неуспешную установку
d:\transact\php\php.exe d:\Transact\wwwroot\risk\mail.php %computername% >> log.log
del d:\transact\temp\copy_ready.flg  >> log.log

ECHO ------------------------------------  >> log.log
ECHO %DATE% - %TIME% - END CHECK STRATEGY  >> log.log
ECHO ------------------------------------  >> log.log

:EOF