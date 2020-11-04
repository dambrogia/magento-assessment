set -e

# This file assumes it is ran from the directory it exists in.
# Install php dependencies.
composer install;

# Install Magento
_user="admin"
_pw="$(echo $RANDOM | md5sum | cut -c1-8)"

./bin/magento setup:install \
    --admin-firstname="denzel" \
    --admin-lastname="washington" \
    --admin-email="denzel@washington.com" \
    --admin-user="${_user}" \
    --admin-password="${_pw}" \
    --base-url="http://localhost:3005/" \
    --backend-frontname="admin" \
    --db-host="local_dev_db" \
    --db-name="mage" \
    --db-user="docker" \
    --db-password="docker" \
    --use-secure=0 \
    --use-secure-admin=0

# Compile
./bin/magento setup:di:compile

./bin/magento setup:upgrade
./bin/magento deploy:mode:set developer

find . -type f -exec chmod 644 {} +;
find . -type d -exec chmod 755 {} +;
find app/etc generated pub/static var -type d -exec chmod 775 {} +;
find app/etc generated pub/static var -type f -exec chmod 664 {} +;
chgrp www-data . -R
chmod u+x bin/magento install.sh
