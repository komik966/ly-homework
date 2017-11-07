[![Coverage Status](https://coveralls.io/repos/github/komik966/ly-homework/badge.svg?branch=master)](https://coveralls.io/github/komik966/ly-homework?branch=master)

Run with Docker
===============
`docker build . -t ly-homework`

Without mounted dir:

1. `docker run -p 4000:80 --name ly-homework ly-homework`
2. `docker exec -u root ly-homework /etc/init.d/nginx start`

With mounted dir:

1. `docker run -p 4000:80 --name ly-homework --mount type=bind,source="$(pwd)",destination=/var/www/html ly-homework`

2. `docker exec -u root ly-homework /etc/init.d/nginx start`