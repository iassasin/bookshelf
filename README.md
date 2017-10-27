# Bookshelf symfony project
Before using this site you need to install:
- postgresql, create user and database to store site data.
- php apcu for database query cache (`apt-get install php-acpu`)

After that execute in terminal (at linux) next commands:
```bash
# clone repo and go to project directory
git clone https://github.com/iassasin/bookshelf.git bookshelf
cd bookshelf

# install dependencies
composer install
npm install

# generate js and css
npm run dev

# create admin user
php bin/console fos:user:create admin
# promote to created user ROLE_ADMIN
php bin/console fos:user:promote admin ROLE_ADMIN

# run server
php bin/console server:run
# now you can open http://localhost:8000/ in your browser
```
