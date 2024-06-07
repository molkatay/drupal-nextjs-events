#!/bin/bash

STAGED_FILES=$(git diff --cached --name-only --diff-filter=ACMR)

drupal_root=$(pwd)"/drupal"

PHPCS_BIN="docker run --rm -v $(pwd):/app -w /app druxt-events_php phpcs --standard=Drupal --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml"
PHPCBF_BIN="docker run --rm -v $(pwd):/app -w /app druxt-events_php phpcbf --standard=Drupal --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml"
PHPSTAN_BIN="docker run --rm -v $drupal_root:/app -w /app druxt-events_php ./vendor/bin/phpstan"
PHPUNIT_BIN="docker run --rm -v $drupal_root:/app -w /app druxt-events_php ./vendor/bin/phpunit"
# Check for PHPCS / PHPCBF
if ! command -v $PHPCS_BIN &> /dev/null; then
    echo "[PRE-COMMIT] PHP CodeSniffer is not installed locally."
    echo "[PRE-COMMIT] Please run 'composer install' or check the path: $PHPCS_BIN"
    exit 1
fi

if ! command -v $PHPCBF_BIN &> /dev/null; then
    echo "[PRE-COMMIT] PHP Code Beautifier and Fixer is not installed locally."
    echo "[PRE-COMMIT] Please run 'composer install' or check the path: $PHPCBF_BIN"
    exit 1
fi


# Check for PHPSTAN
if ! command -v $PHPSTAN_BIN &> /dev/null; then
    echo "[PRE-COMMIT] PHP STAN is not installed locally."
    echo "[PRE-COMMIT] Please run 'composer install' or check the path: $PHPSTAN_BIN"
    exit 1
fi
# Check for PHPUNIT
if ! command -v $PHPUNIT_BIN &> /dev/null; then
    echo "[PRE-COMMIT] PHPUNIT is not installed locally."
    echo "[PRE-COMMIT] Please run 'composer install' or check the path: $PHPUNIT_BIN"
    exit 1
fi
ESLINT="docker run --rm -v $(pwd):/app -w /app deploy_dev_env_drupal ./drupal/node_modules/.bin/eslint"
ESLINT="./drupal/node_modules/.bin/eslint"




for FILE in $STAGED_FILES; do
    if [[ $FILE =~ \.php$|\.inc$|\.module|\.theme$ ]]; then
        $PHPCS_BIN $FILE  --standard=PSR12
        # shellcheck disable=SC2181
        if [ $? -ne 0 ]; then
            echo "[PRE-COMMIT] Coding standards errors have been detected."
            echo "[PRE-COMMIT] Running PHP Code Beautifier and Fixer..."

            # You can change your PHPCBF command here
            $PHPCBF_BIN -n $FILE  --standard=PSR12

            echo "[PRE-COMMIT] Checking PHPCS again..."

            # You can change your PHPCS command here
            $PHPCS_BIN -n $FILE  --standard=PSR12

            if [ $? != 0 ]
            then
                echo "[PRE-COMMIT] PHP Code Beautifier and Fixer wasn't able to solve all problems."
                echo "[PRE-COMMIT] Run PHPCS manually to check and fix all errors."
                exit 1
            fi

            echo "[PRE-COMMIT] All errors are fixed automatically."

            git add $FILE
        else
            echo "[PRE-COMMIT] No errors found."
        fi

        file_to_analyse=${FILE//"drupal/"/}
        #Run PHPSTAN
#        $PHPSTAN_BIN analyse $file_to_analyse --error-format=json --no-progress --ansi
#        if [ $? -ne 0 ]; then
#            echo "PHPSTAN detected errors. Commit aborted."
#            exit 1
#        fi
#        $PHPUNIT_BIN -c phpunit.xml --testsuite unit --coverage-clover drupal-coverage.xml --bootstrap web/core/tests/bootstrap.php $file_to_analyse


    elif [[ $FILE =~ \.js$ ]]; then
        $ESLINT "$FILE"
        if [ $? -ne 0 ]; then
            echo "ESLint detected errors. Commit aborted."
            exit 1
        fi
    fi

done
exit 0
