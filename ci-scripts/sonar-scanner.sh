#!/bin/bash
drupal_root=$(pwd)"/drupal"

STAGED_FILES=$(git diff --cached --name-only --diff-filter=ACMR)
STAGED_FILES_STRING=$(echo "$STAGED_FILES" | tr '\n' ',' | sed 's/,$//')

PHPUNIT_BIN="docker run --rm -v $drupal_root:/app -w /app druxt-events_php php -n -dxdebug.mode=coverage ./vendor/bin/phpunit"

$PHPUNIT_BIN -c phpunit.xml --testsuite unit --coverage-clover drupal-coverage.xml --log-junit=build/phpunit.xml --bootstrap web/core/tests/bootstrap.php web
# Check for PHPUNIT
if ! command -v $PHPUNIT_BIN &> /dev/null; then
    echo "[PRE-COMMIT] PHPUNIT is not installed locally."
    echo "[PRE-COMMIT] Please run 'composer install' or check the path: $PHPUNIT_BIN"
    exit 1
fi
container_name="sonarqube"

container_ip=$(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "$container_name")


# Run SonarQube analysis
docker run  --rm -v $PWD:/usr/src --link sonarqube --net my_drupal9_decoupled_sonar newtmitch/sonar-scanner sonar-scanner \
-Dsonar.projectKey=Druxt-events \
-Dsonar.sources=$STAGED_FILES_STRING \
-Dsonar.qualitygate.wait=true \
-Dsonar.host.url=http://$container_ip:9000 \
-Dsonar.token=sqp_abea744536a72429cfb6bc57905c0615def0af8b \
-Dsonar.php.coverage.reportPaths=drupal/drupal-coverage.xml \
-Dsonar.language=php \
-Dsonar.exclusions=**/vendor/**,**/libraries/**,**/node_modules/**,**/core/**,**/sites/**,**/contrib/**,**/drush/**,**/files/**,**/default* \
-Dsonar.scm.exclusions.disabled=true \
-Dsonar.login=admin \
-Dsonar.password=molka \
-Dsonar.sourceEncoding=UTF-8 \
-Dsonar.security.php.rules=true \
-Dsonar.security.javascript.rules=true
# Continue with the commit if SonarQube analysis passes
  if [ $? -ne 0 ]; then
    echo "SonarQube analysis failed. Commit aborted."
    exit 1
else
    echo "SonarQube analysis passed. Committing changes."
    exit 0
fi
