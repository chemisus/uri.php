PHP:=$(shell which php)
COMPOSER_PHAR=composer.phar
COMPOSER_LIB=vendor
COMPOSER=$(PHP) $(COMPOSER_PHAR)
PHPUNIT=$(COMPOSER_LIB)/bin/phpunit
PHPUNIT_LIB=$(COMPOSER_LIB)/phpunit/phpunit
OUT=out
COVERAGE=$(OUT)/coverage.xml

.PHONY: test
test: vendor/phpunit/phpunit
	$(PHPUNIT) \
		--bootstrap vendor/autoload.php \
		test/


$(COMPOSER):
	$(PHP) -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	$(PHP) -r "if (hash_file('sha384', 'composer-setup.php') === 'c5b9b6d368201a9db6f74e2611495f369991b72d9c8cbd3ffbc63edff210eb73d46ffbfce88669ad33695ef77dc76976') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	$(PHP) composer-setup.php
	$(PHP) -r "unlink('composer-setup.php');"
	$(COMPOSER) self-update

$(PHPUNIT_LIB): $(COMPOSER)
	$(COMPOSER) require --dev phpunit/phpunit

$(PHPUNIT): $(PHPUNIT_LIB)

.PHONY: clean
clean:
	rm -r $(COMPOSER_PHAR) $(COMPOSER_LIB) $(OUT)
