@echo off
echo Creating directory structure...

:: Create directories
mkdir "public\views\auth" 2>nul
mkdir "public\views\dashboard" 2>nul
mkdir "public\views\shared" 2>nul
mkdir "public\assets\css" 2>nul
mkdir "public\assets\js" 2>nul
mkdir "src\config" 2>nul
mkdir "src\handlers" 2>nul
mkdir "src\includes" 2>nul
mkdir "src\models" 2>nul

:: Move files to appropriate directories
echo Moving files to new structure...

:: Move HTML files
move "*.html" "public\views\" 2>nul

:: Move CSS files
move "css\*" "public\assets\css\" 2>nul

:: Move JS files
move "js\*" "public\assets\js\" 2>nul

:: Move PHP files
move "handlers\*" "src\handlers\" 2>nul
move "includes\*" "src\includes\" 2>nul
move "config\*" "src\config\" 2>nul

:: Move main PHP files to src
move "*.php" "src\" 2>nul
move "src\index.php" "public\" 2>nul

:: Create .htaccess file
echo Creating .htaccess file...
echo RewriteEngine On > public\.htaccess
echo RewriteCond %%{REQUEST_FILENAME} !-f >> public\.htaccess
echo RewriteCond %%{REQUEST_FILENAME} !-d >> public\.htaccess
echo RewriteRule ^(.*)$ index.php [QSA,L] >> public\.htaccess

echo Done!
