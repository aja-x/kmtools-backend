# Wissen Backend

## Installation
Clone project<br>
`$ git clone https://github.com/aja-x/kmtools-backend.git`<br>

Change directory<br>
`$ cd kmtools-backend`<br>

Install vendor<br>
`$ composer install`<br>

Run migration<br>
`$ php artisan migrate --seed`

Run local server<br>
`$ php -S localhost:8000 -t public`


## Docker
Build<br>
`$ docker build . -f deploy/docker/Dockerfile -t your-username/your-image-name`<br>

Run<br>
`$ docker run -dp 127.0.0.1:8000:80 -it your-username/your-image-name `
<br>then check on your browser at `127.0.0.1:8000`

## Kubernetes
For kubernetes deployment, check file at `deploy/k8s/`
