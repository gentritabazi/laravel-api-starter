echo "Installing Clean Laravel Api..."

composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link

echo "Clean Laravel Api Installed!"
