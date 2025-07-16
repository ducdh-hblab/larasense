#!/bin/sh

# Calculate dynamic values based on memory
MAX_CHILDREN=$(free -m | awk 'FNR == 2 {print int(($2-200)/30 / 5) * 5}')
MIN_SPARE=$(($MAX_CHILDREN / 5))
MAX_SPARE=$(($MIN_SPARE * 2))
START=$(($MIN_SPARE + ($MAX_SPARE - $MIN_SPARE) / 2))

# Update PHP-FPM config with calculated values
# Auto calc
sed -i "s/pm.max_children =.*/pm.max_children = $MAX_CHILDREN/" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/pm.start_servers =.*/pm.start_servers = $START/" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/pm.min_spare_servers =.*/pm.min_spare_servers = $MIN_SPARE/" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/pm.max_spare_servers =.*/pm.max_spare_servers = $MAX_SPARE/" /usr/local/etc/php-fpm.d/www.conf

# For 2vCPU, 4Gb Memory
#sed -i "s/pm.max_children =.*/pm.max_children = 500/" /usr/local/etc/php-fpm.d/www.conf
#sed -i "s/pm.start_servers =.*/pm.start_servers = 150/" /usr/local/etc/php-fpm.d/www.conf
#sed -i "s/pm.min_spare_servers =.*/pm.min_spare_servers = 100/" /usr/local/etc/php-fpm.d/www.conf
#sed -i "s/pm.max_spare_servers =.*/pm.max_spare_servers = 200/" /usr/local/etc/php-fpm.d/www.conf

# Log the applied configuration
echo "Configured PHP-FPM:"
echo "pm.max_children = $MAX_CHILDREN"
echo "pm.start_servers = $START"
echo "pm.min_spare_servers = $MIN_SPARE"
echo "pm.max_spare_servers = $MAX_SPARE"

# cache route
php artisan route:cache

# cache config
php artisan config:cache


chown -R www:www /var/www/storage /var/www/bootstrap/cache
chmod -R 777 /var/www/storage /var/www/bootstrap/cache
