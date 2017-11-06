Run with Docker
===============
`docker build . -t ly-homework`

Without mounted dir:

`docker run -p 4000:80 ly-homework`

With mounted dir:

`docker run -p 4000:80 --mount type=bind,source="$(pwd)",destination=/var/www/html ly-homework`