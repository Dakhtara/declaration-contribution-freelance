.DEFAULT_GOAL := help

DEV_CONSOLE = php bin/console
TEST_CONSOLE = $(DEV_CONSOLE) --env=test

reset-db: ## Reset BDD for dev env
	$(DEV_CONSOLE) doctrine:database:drop --force --if-exists
	$(DEV_CONSOLE) doctrine:database:create
	$(DEV_CONSOLE) doctrine:schema:create
	$(DEV_CONSOLE) doctrine:fixtures:load -n

test-full: ## Reset BDD and reload fixtures before test
	$(TEST_CONSOLE) doctrine:database:drop --force --if-exists
	$(TEST_CONSOLE) doctrine:database:create
	$(TEST_CONSOLE) doctrine:schema:create
	$(TEST_CONSOLE) doctrine:fixtures:load -n
	bin/phpunit

cs-fix:
	./vendor/bin/php-cs-fixer fix
test: ## Just run the tests
	bin/phpunit

git-hooks: ## Configure git-hooks
	- git config core.hooksPath etc/git-hooks

help: ## Show this help
	@egrep '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
