
# How to start project




## Clone the project

```
git clone https://github.com/reinisalpins/mapon-currencies-task.git
```

## Installing Composer Dependencies

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

## Pull the images and start the project

```
./vendor/bin/sail up -d
```

## Run the migrations in project directory

```
./vendor/bin/sail artisan migrate:fresh
```

## Load the last 7 days of data from bank.lv

```
./vendor/bin/sail artisan exchange-rates:load --past-week
```

## Start the front-end

```
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```
