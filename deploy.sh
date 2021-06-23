# Create directory
mkdir library-api

# Change to the project directory
cd library-api

# Clone project by Github
git clone https://github.com/RuslanUI/library-api .

# Install Sail
php artisan sail:install

# Start project
./vendor/bin/sail up -d