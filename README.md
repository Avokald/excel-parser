# Excel parser 

### Tech

- docker 
- supervisor 
- laravel 
- rabbitmq 
- queues 
- pusher
- laravel-echo

### Setup

After downloading the folder in command line:

```shell
docker-compose up -d

docker-compose exec app php composer.phar install 

docker-compose exec app cp .env.example .env

# Add pusher params into .env file

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan migrate

```

### dev

```shell
docker-compose exec app npm install

// build
docker-compose exec app npm run production
```

### Problems

Events sent to laravel echo comes in random order even thought they are sent from one worker.

Id column in a test file is unparsable with batch reading because it uses the formula 
that takes previous value recursively. WithCalculatedFormula and WithPreCalculatedFormula 
concerns did not compute it correctly.

Queue starts while rabbitmq is not completely loaded, creating error messages in laravel.log file.

Error with bash\r - on Windows with CLRF on. Solution:
```shell
git config --global core.eol lf
git config --global core.autocrlf input
 
git rm -rf --cached .
git reset --hard HEAD 
```



### References
https://docs.laravel-excel.com/3.1/imports/model.html - laravel excel parser

https://laravel-news.com/laravel-scheduler-queue-docker - docker build for laravel queues

https://laravel.com/docs/8.x/queues#supervisor-configuration - supervisor configuration

https://stackoverflow.com/questions/48884802/docker-laravel-queuework - how to send supervisor into awaiting state

https://github.com/vyuldashev/laravel-queue-rabbitmq - queues through rabbitmq (set RABBITMQ_QUEUE in .env)



