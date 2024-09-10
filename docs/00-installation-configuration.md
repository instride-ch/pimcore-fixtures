# Installation

Install Fixtures Bundle:
```
composer require instride/pimcore-fixtures
```

## Setup

### Test Environment with phpunit
If you want to run the fixtures in a test environment, a .env.test file should be created in the root directory of the project, else, env.local is used.
.env.test could look like this:
```
# define your env variables for the test env here
APP_ENV=test
KERNEL_CLASS='App\Kernel'
```
### *Important*
If you configured phpunit to run in the test environment, you will also need a /config/test/database.yaml file with the database configuration for the test environment.

Don't forget to install you database schema in the test environment:
```
APP_ENV=test php vendor/bin/pimcore-install --admin-username *ADMIN_USERNAME* \
                                                                               --admin-password *ADMIN_PASSWORD* \
                                                                               --mysql-username *MYSQL_USERNAME* \
                                                                               --mysql-password *MYSQL_PASSWORD* \
                                                                               --mysql-database *MYSQL_DATABASE* \
                                                                               --mysql-host-socket *MYSQL_HOST_SOCKET* \
                                                                               --mysql-port *PORT* \
                                                                               --ignore-existing-config \
                                                                               --no-interaction \
                                                                      --skip-database-config
```
