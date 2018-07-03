# source environment variables to use php 7.1
source scl_source enable rh-php71

dir="/var/www/nmsprime"

cd "$dir"
/opt/rh/rh-php71/root/usr/bin/php artisan module:publish
/opt/rh/rh-php71/root/usr/bin/php artisan module:migrate
/opt/rh/rh-php71/root/usr/bin/php artisan nms:auth

chown -R apache $dir/storage $dir/bootstrap/cache
