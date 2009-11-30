#!/bin/bash


DATE=`date +%m%d%H%M%S`;

mkdir /var/www/fazey.org/reports/$DATE

php pdepend.php  --ignore=/var/www/cents.fazey.org/test,/var/www/cents.fazey.org/sensiblephp/test --jdepend-chart=jdepchart$DATE.svg --jdepend-xml=jdepxml$DATE.xml --overview-pyramid=pyr$DATE.svg --phpunit-xml=phpunit$DATE.xml --summary-xml=summary$DATE.xml --bad-documentation --without-annotations /var/www/cents.fazey.org/

mv *.svg *.xml /var/www/fazey.org/reports/$DATE/
chown -R james:james /var/www/fazey.org/reports/$DATE/
sleep 1
phpunit --colors --coverage-html=/var/www/fazey.org/reports/$DATE/coverage --testdox-html=/var/www/fazey.org/reports/$DATE/testdox.html /var/www/cents.fazey.org/

# Removing unmentionables

grep -v password /var/www/fazey.org/reports/$DATE/coverage/conf_Settings.class.php.html > /var/www/fazey.org/reports/$DATE/coverage/conf_Settings.class.php.html.tmp
mv /var/www/fazey.org/reports/$DATE/coverage/conf_Settings.class.php.html.tmp /var/www/fazey.org/reports/$DATE/coverage/conf_Settings.class.php.html


# Setting the proper file ownership.
chown -R james:james /var/www/fazey.org/reports/

