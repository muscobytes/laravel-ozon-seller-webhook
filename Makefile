#!make

TAG=muscobytes/php-8.1-cli
DOCKER=docker run -ti --volume "$(shell pwd):/var/www/html" $(TAG)

.PHONY: help build shell test install update
help:      ## Shows this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
build:
	docker build --progress plain --tag $(TAG) --file "$(shell pwd)/Dockerfile" .
shell:
	${DOCKER} sh
test:
	${DOCKER} ./vendor/bin/phpunit tests
install:
	${DOCKER} composer install
update:
	${DOCKER} composer update
