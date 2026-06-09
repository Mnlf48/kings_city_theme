@echo off
echo ========================================================
echo The Kings City Club - Auto Sync to WordPress
echo ========================================================
echo.

:: IMPORTANT: Change this path to match your actual local WordPress installation
SET WP_THEME_DIR=C:\xampp\htdocs\the-kings-city-club\wp-content\themes\the-kings-city-club
SET SOURCE_DIR=%~dp0the-kings-city-club

echo Source: %SOURCE_DIR%
echo Target: %WP_THEME_DIR%
echo.
echo Starting robocopy in monitor mode...
echo (It will check for changes every 1 minute and sync automatically)
echo Press Ctrl+C to stop.
echo.

:: /MIR: Mirror directory tree
:: /MOT:1: Monitor source; run again in 1 minute if changed
:: /NDL: No Directory List (cleaner output)
robocopy "%SOURCE_DIR%" "%WP_THEME_DIR%" /MIR /MOT:1 /NDL

pause
