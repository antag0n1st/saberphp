
set /p dir_name=Where to install ? 
set /p name=What is the title of the application ?
set /p db_name= Database name ?
set /p db_user= Database user default(root) ?
set /p db_pass= Database pass default() ?
set /p email=Email Sender default(trbogazov@gmail.com) ?

php ./install.php --dir=%dir_name% --name=%name% --db_name=%db_name% --db_user=%db_user% --db_pass=%db_pass% --email=%email%

start "" http://localhost/%dir_name%

timeout 10