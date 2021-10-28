.DEFAULT_GOAL := help



ENV_CONSOLE = php bin/console --env=test

test-full: ## Reset BDD and reload fixtures before test
	$(ENV_CONSOLE) doctrine:database:drop --force
	$(ENV_CONSOLE) doctrine:database:create
	$(ENV_CONSOLE) doctrine:schema:create
	$(ENV_CONSOLE) doctrine:fixtures:load -n
	bin/phpunit

test: ## Just run the tests
	bin/phpunit
help: ## Show this help
	@egrep '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
