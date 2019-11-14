Note: We need to find available [Docker Network](https://docs.docker.com/v17.09/engine/userguide/networking/) and [Docker Port](https://docs.docker.com/engine/reference/commandline/port/).

Make change in file `docker-compose.yml`:

```
networks:
      gaohaihau_net:
        ipv4_address: 172.20.0.10 <- Change this with available IP

```

and

``` 
    ports:
           - "443:443" <- Make change if it not available
           - "80:80" <- Make change if it not available
           - "2222:22" <- Make change if it not available
```


Step 1:  Build and start your environment

We open command line tool (`Terminal` on Linux or `Command Prompt` on Windows) and run bellow command:

``` 
    docker-compose build
```

Run with `sudo` if needed.

```
    sudo docker-compose build 
```

It'll take a few minutes.So [make a cup of coffee](https://www.google.com/search?q=how+to+make+a+cup+of+coffee&oq=how+to+make+a+cup+of+coffee+&aqs=chrome..69i57j0l5.11214j0j7&sourceid=chrome&ie=UTF-8), enjoy it and wait.

After it done right, we'll need to start our container with service.

``` 
docker-compose up -d
``` 
And `sudo` if needed, again.

Step 2: Setting up [Envoy](https://laravel.com/docs/5.7/envoy)

Next, we'll setting up delivery environment, but we need add environment variables:

``` 
APP_NAME=Laravel
APP_REPO=git:abc.git
SLACK_HOOK=notify
SLACK_CHANEL=tech
DEPLOY_DIR=/var/www/html/
DEPLOYER=deployer
DEPLOY_HOST=your_server_ip
```

For delivery our branch of coding.

```
envoy story_name --on=your_environment --branch=your_branch
```

Step 3:

To handle exception in our project, we use [Bugsnag](https://bugsnag.com) for tracking them.

Configure your Bugsnag API Key in your `.env` file:

```
BUGSNAG_API_KEY=your-api-key-here
```


You can find this key immediately after creating a new project from your Bugsnag dashboard, or later on your project’s settings page.

If you’d like to configure Bugsnag further, create and edit a `config/bugsnag.php` file by running:

```
    php artisan vendor:publish
```

For a list of available options, see the configuration options reference.

## Running in production env
- Create private networks
```
docker network create --subnet=172.18.0.0/16 sudobonet
```

- Create nginx-proxy and letsencrypt-nginx-proxy for multi `https` in one machine
```
docker run --detach \
    --restart=always \
    --name nginx-proxy \
    --publish 80:80 \
    --publish 443:443 \
    --volume /etc/nginx/certs \
    --volume /etc/nginx/vhost.d \
    --volume /usr/share/nginx/html \
    --volume /var/run/docker.sock:/tmp/docker.sock:ro \
    --net sudobonet \
    jwilder/nginx-proxy

docker run --detach \
    --restart=always \
    --name nginx-proxy-letsencrypt \
    --volumes-from nginx-proxy \
    --volume /var/run/docker.sock:/var/run/docker.sock:ro \
    --net sudobonet \
    jrcs/letsencrypt-nginx-proxy-companion
```

- Create Mysql and config in `.env` file
```
docker run --detach \
    --restart=always \
    --name gaohaihau_production_db \
    --env "MYSQL_ROOT_PASSWORD=gaohaihau@2019" \
    --env "MYSQL_DATABASE=gaohaihaudb" \
    --env "MYSQL_USER=gaohaihau" \
    --env "MYSQL_PASSWORD=gaohaihau@2019" \
    -p 2021:3306 \
    --net sudobonet \
    --ip 172.18.0.154 \
    mysql:5.7
```
- Create Redis and config in `.env` and `laravel-echo-server.json` file

- Create container for project
```
docker run --detach \
    --restart=always \
    --name gaohaihau_production_web \
    -v /home/sudobo/gaohaihau:/var/www/html/current \
    --env "VIRTUAL_HOST=gaohaihau.com.vn" \
    --env "LETSENCRYPT_HOST=gaohaihau.com.vn" \
    --env "LETSENCRYPT_EMAIL=toi.xtran@gmail.com" \
    -p 2020:22 \
    --net sudobonet \
    gaohaihau_web
```


Contributors: 

[ToiTX](https://github.com/toixtran)

[NghiaNM](https://github.com/andynguyenm)


© 2019 GitHub, Inc.
