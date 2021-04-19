echo "Installing Project..."

docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install
cp .env.example .env
./vendor/bin/sail up -d && ./vendor/bin/sail artisan key:generate && ./vendor/bin/sail artisan storage:link

echo "Project Installed!"
