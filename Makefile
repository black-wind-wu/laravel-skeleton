# Project Makefile
# -------------------

default: help

install:	##@system build this application
	git pull
	php -r "file_exists('.env') || copy('.env.prod', '.env');"
	composer install --prefer-dist --no-dev --optimize-autoloader --no-progress --no-interaction
	chmod +x artisan
	php artisan storage:link
	php artisan migrate --seed
	$(MAKE) optimize

update:	##@update this application
	git pull
	php artisan migrate --force
	php artisan queue:restart
	$(MAKE) optimize

reload:	##@reload this application
	rm -f .env
	rm -rf vendor/
	git pull
	php -r "file_exists('.env') || copy('.env.prod', '.env');"
	composer install --prefer-dist --no-dev --optimize-autoloader --no-progress --no-interaction
	php artisan migrate --force
	php artisan queue:restart
	$(MAKE) optimize

optimize:	##@system build this application cache
	php artisan optimize

# Help based on https://gist.github.com/prwhite/8168133 thanks to @nowox and @prwhite
# And add help text after each target name starting with '\#\#'
# A category can be added with @category

HELP_FUN = \
		%help; \
		while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([\w-]+)\s*:.*\#\#(?:@([\w-]+))?\s(.*)$$/ }; \
		print "\nusage: make [target ...]\n\n"; \
	for (keys %help) { \
		print "$$_:\n"; \
		for (@{$$help{$$_}}) { \
			$$sep = "." x (25 - length $$_->[0]); \
			print "  $$_->[0]$$sep$$_->[1]\n"; \
		} \
		print "\n"; }

help:				##@system show this help
	#
	# General targets
	#
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)
