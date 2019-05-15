DOCKER_COMPOSE 		= docker-compose
EXEC_PHP 			= $(DOCKER_COMPOSE) exec ${EXEC_OPT} php
COMPOSER_PHP 		= $(EXEC_PHP) composer

install:
	make start
	chmod +x docker/wait-for-mysql.sh && ./docker/wait-for-mysql.sh
	make vendors
	make db

vendors:
	$(COMPOSER_PHP) install

start:
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop:
	$(DOCKER_COMPOSE) stop

clean:
	$(DOCKER_COMPOSE) down --rmi all

db:
	$(DOCKER_COMPOSE) exec -T mysql mysql -u root -h mysql doctissimo < resource/database.sql