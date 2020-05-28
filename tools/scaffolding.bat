@echo off

echo Create new ? Y/N default (no)
set /p create_new=
if "%create_new%"=="y" (

echo What is the table name ? - make it PLURAL!
set /p model_name=
goto create

) else (

goto rest

) 

:create
copy NUL "../config/scaffolding/models/%model_name%"
:loop

echo Enter a Field (type "end" to stop)
set /p field=
if "%field%"=="end" (
goto rest
) else (
echo %field% >> ../config/scaffolding/models/%model_name%
goto loop
)

:rest


cd ../config/scaffolding/models
echo Available Models:
echo.
dir /b /a-d 
echo.
echo Which Model do you want to create ? default (none) options (name \ all \ none)
set /p model_name=
echo What do you want to do ? default (r) options: 
echo - o overwrite all 
echo - r recreate table
echo - m create model and table
echo - d delete
set /p mode=

cd ../../../tools
php ./scaffolding.php --mode=%mode% --model_name=%model_name%
pause
