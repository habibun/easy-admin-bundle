.PHONY: init
init: ## create .env.local file from .env
	cp -u -p .env .env.local

.PHONY: install
install: ## install
	symfony composer install
	yarn install
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate -n
	symfony console doctrine:fixtures:load -n

.PHONY: reset-db
reset-db: ## reset database
	symfony console doctrine:database:drop --force
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate -n

.PHONY: start
start: ## start
	symfony server:start

.PHONY: log
start: ## log
	symfony server:log
