# РБК NEWS
Web приложения для просмотра последних новстей с РБК.

Docker-compose version 3.7

# Перед первым запуском!
```sh
 cp .env.dist .env
 ln .env news-web/
 make docker-build
 make migrate
```
# Далее для Новостей
- RSS
```sh
 make load-news-rss
```
или
- JSON API (newsapi.org)
```sh
 make load-news-json
```

# Для запуска (default 171.10.3.103)
 - Для Production
```sh
 make start-prod
```
- Для Development
```sh
 make start-dev
```
# Для запуска тестов
```sh
 make test
```