# Visitor Tracker for Laravel

A simple and flexible Laravel package to track website visitors and page visits.

## Installation
```bash
composer install kitoko/tracker-visitor
```

## Publish config
```
php artisan vendor:publish --tag=visitor-tracker-config
```
This command will generate 
```
config/visitor-tracker.php
```
## Run migration
````
php artisan migrate
````
