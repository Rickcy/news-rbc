include .env
CMD=
NAME=
pwd=.


# ln .env /news-web/

# docker-build -> migrate -> load-news-rss || load-news-json ->  start-prod || start-dev

.PHONY: docker-up watch build docker-build docker-down docker-entry docker-restart docker-logs info-commands htop start-prod start-dev load-news-json load-news-rss


#Информация о коммандах
info-commands:
	less Makefile
#Полный запуск c нуля

start-prod: docker-up build

start-dev: docker-up watch

test:
	docker-compose exec news-web su -c 'composer install && ./vendor/bin/codecept run' web

#Сборка образов с параметрами
docker-build:
	docker-compose build

migrate:docker-up
	docker-compose exec news-web su -c 'composer install && ./yii migrate' web

docker-up:
	docker-compose up -d

docker-restart:
	docker-compose restart
#Проверка поднятых инстансев

docker-ps:
	docker-compose ps

#Останавливает контейнеры и удаляет контейнеры, сети, тома и изображения
docker-down:
	docker-compose down --remove-orphans
#Показать логи
docker-logs:
	docker-compose logs

#Войти в образ на уровень командной строки
docker-entry:
	docker-compose exec $(NAME) bash

#Перезапустить  приложение
restart: docker-restart

#Установить зависимости приложения
build:
	docker-compose exec news-web su -c 'composer install' web && docker-compose exec news-front su -c 'npm install && npm run build' node

load-news-rss:
	docker-compose exec news-web su -c './yii news/load-rss' web

load-news-json:
	docker-compose exec news-web su -c './yii news/load-json' web

watch:
	docker-compose exec news-web su -c 'composer install' web && docker-compose exec news-front su -c 'npm install && npm run build-watch' node

htop:
	docker-compose exec ${NODE_CONTAINER_NAME} htop
