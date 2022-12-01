# REST API
REST API je napsána v PHP frameworku Laravel a částečně uspokojuje obdržené zadání.

# Návod ke zprovoznění
1) Obsah souboru `.env.example` je třeba zkopírovat do nového souboru `.env`. V souboru `.env` je poté třeba nastavit přihlašovací údaje k databázi.
2) Spuštění příkazu `composer install`
3) Vygenerování aplikačního klíče příkazem `php artisan key:generate`
4) Spuštění migrací databáze příkazem `php artisan migrate:fresh` a případné naplnění testovacími daty příkazem `php artisan db:seed`
5) Jednoduchý PHP server pro zprovoznění aplikace lze spustit příkazem `php artisan serve`
