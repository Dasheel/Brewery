# Laravel Brewery Project

Questo progetto è una web application Laravel che fornisce una funzionalità di login tramite **username** e **password**, genera un token JWT per autenticare l'utente e consente la visualizzazione di una lista paginata di birrerie tramite un'integrazione con l'API di [OpenBreweryDB](https://www.openbrewerydb.org/).

## Requisiti
- [Docker](https://www.docker.com/get-started)
- [OrbStack](https://orbstack.dev/) (opzionale per utenti Mac)
- [Composer](https://getcomposer.org/) (se vuoi eseguire composer direttamente)

## Setup del Progetto

### 0. Scegliere docker-compose
In base al sistema operativo che utilizzi, rinomina il file docker-compose_mac.yml o docker-compose_windows.yml in docker-compose.yml.
Stessa cosa vale per il file Dockerfile
```bash
Per mac
docker-compose_mac.yml -> mv docker-compose_mac.yml docker-compose.yml
Dockerfile_mac -> mv Dockerfile_mac Dockerfile

Per windows
docker-compose_windows.yml -> mv docker-compose_windows.yml docker-compose.yml
Dockerfile_windows -> mv Dockerfile_windows Dockerfile
```
Creare il file .env
```bash
cp .env.example .env
```
### 1. Avviare il container
Una volta selezionato il file corretto, puoi avviare il container eseguendo (assicurarsi di essere nella cartella del progetto):
```bash
docker-compose up --build -d
```
### 2. Verificare lo stato dei servizi
Assicurati che tutti i servizi siano in esecuzione correttamente:
```bash
docker-compose ps
```
Esempio di Output:
```bash
NAME           IMAGE                  COMMAND                  SERVICE     CREATED         STATUS         PORTS
laravel_app    arm64v8/php:8.2-fpm    "entrypoint.sh"          app         8 seconds ago   Up 7 seconds   9000/tcp, 0.0.0.0:8000->80/tcp, [::]:8000->80/tcp
mysql_db       mysql:8.0              "docker-entrypoint.s…"   db          8 seconds ago   Up 7 seconds   0.0.0.0:3306->3306/tcp, :::3306->3306/tcp, 33060/tcp
nginx_server   arm64v8/nginx:alpine   "/docker-entrypoint.…"   webserver   8 seconds ago   Up 7 seconds   0.0.0.0:8080->80/tcp, [::]:8080->80/tcp
```
### 3. Inizializzare l'applicazione Laravel
Accedi al container dell'applicazione per installare le dipendenze PHP e configurare l'applicazione:
```bash
docker exec -it laravel_app bash
```
All'interno del container, esegui i seguenti comandi:
```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
```
Questi comandi installano le dipendenze, generano la chiave dell'applicazione e creano il database con i dati di esempio .
### 4. Eseguire il test
Sempre all'interno del container, puoi eseguire tutti i test del progetto:
```bash
composer test
```

### 4. Accedere all'applicazione da browser
Ora puoi accedere al login tramite browser visitando:
```bash
http://localhost:8080/login

Credeniali:
username = root
password = password
```
NB: se dice credenziali sbagliate rilanciate la migration:
```bash
php artisan migrate:fresh --seed
```






