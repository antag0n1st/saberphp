@echo off
echo Where to install ? 
set /p dir_name=
echo What is the title of the application ?
set /p name=
echo Database name ?
set /p db_name=
echo Database user default(root) ?
set /p db_user=
echo Database pass default() ?
set /p db_pass=
echo Email Sender default(trbogazov@gmail.com) ?
set /p email=

php ./install.php --dir="%dir_name%" --name="%name%" --db_name="%db_name%" --db_user="%db_user%" --db_pass="%db_pass%" --email="%email%"

start "" http://localhost/%dir_name%

timeout 10