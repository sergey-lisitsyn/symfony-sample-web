ifndef ENV
	ENV=dev
endif

ifndef UID
	UID=`id -u`
endif

ifndef GID
	GID=`id -g`
endif

.PHONY: tests

COMPOSE=docker-compose -f docker-compose.yaml

env:
	@echo "Setting up UID and GID for $(ENV) ..."
	@echo "UID is $(UID)"
	@echo "GID is $(GID)"
	@echo "ENV is $(ENV)"
	@sed -i -r "s~^UID=[0-9]+~UID=$(UID)~g" .env
	@sed -i -r "s~^GID=[0-9]+~GID=$(GID)~g" .env
	@sed -i -r "s~^APP_ENV=[a-z]+~APP_ENV=$(ENV)~g" .env
	@echo "Set up of .env for $(ENV) is completed!"

clean:
	@echo "Stopping all containers and cleaning $(ENV) ..."
	@docker stop $$(docker ps -a -q)
	@yes | docker system prune
	@echo "Cleaned $(ENV) !"

clean-all:
	@echo "Stopping all containers and cleaning $(ENV) ..."
	@docker stop $$(docker ps -a -q)
	@yes | docker system prune -a
	@echo "Cleaned $(ENV) !"

build: env
	@echo "Building $(ENV) ..."
	@$(COMPOSE) -f docker-compose.$(ENV).yaml up -d --build
	@echo "Built $(ENV) !"

up: build
	@echo "Starting $(ENV) ..."
	@$(COMPOSE) -f docker-compose.$(ENV).yaml exec -T php composer install
	# @$(COMPOSE) -f docker-compose.$(ENV).yaml exec -T php php bin/console doctrine:migrations:migrate --no-interaction
	@echo "Built $(ENV) !"

down:
	@echo "Stopping $(ENV) ..."
	@$(COMPOSE) -f docker-compose.$(ENV).yaml down
	@echo "Stopped $(ENV) !"
