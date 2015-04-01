#!/bin/bash

EXIT_STATUS=0

bin/phpunit -c app/
bin/behat --tags=account -fprogress || EXIT_STATUS=$?
bin/behat --tags=organization -fprogress || EXIT_STATUS=$?
bin/behat --tags=project  -fprogress || EXIT_STATUS=$?
bin/behat --tags=dashboard  -fprogress || EXIT_STATUS=$?
bin/behat --tags=timesheet  -fprogress || EXIT_STATUS=$?

exit $EXIT_STATUS;
