## Spis treści
* [Opis projektu](#opis-projektu)
* [Wykorzystane technologie](#wykorzystane-technologie)
* [ENV Laravelowy](#env-laravelowy)
* [Start projektu](#start-projektu)

## Opis projektu
Projekt przedstawia podstawowe średnio zaawansowane REST API, z którego można skorzystać po uprzednim zarejestrowaniu się.
W projekcie można swobotnie dodawać, usuwać oraz edytować wprowadzone posty, komentarze. 

Projekt powstał w czasie wolnym. Głównym celem jest przetestowanie funcji i możliwości jakie daje Laravel 8 w praktyce.

### Wykorzystane technologie  

- Php v. 7.4.9
- Laravel v. 8.0+
- Front: Bootstrap v. 4.0.0

#### ENV Laravelowy
    Wymagane jest połączenie do podstawowej baz danych.
    Standardowy plik env.
    
    Przykładowe polączenie do bazy wapteki lokalnie: 
    DB_HOST=localhost
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    
#### Start projektu
Aby wystartować projekt należy go lokalnie zainstalować wykorzyctując npm

```
$ cd ../laravelREST_API
$ npm install
```
Należy pamiętać o migracji

```
$ cd ../laravelREST_API
$ php artisan migrate
```
Istnieje także możliwość skorzystanie z DatabaseSeeder, który sztucznie uzupełni bazę danych. 

```
$ php artisan db:seed
```
    Readme created 2021-05-21
