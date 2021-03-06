[![Coverage Status](https://coveralls.io/repos/github/komik966/ly-homework/badge.svg?branch=master)](https://coveralls.io/github/komik966/ly-homework?branch=master)
[![Build Status](https://travis-ci.org/komik966/ly-homework.svg?branch=master)](https://travis-ci.org/komik966/ly-homework)

Run with Docker
===============
1. Build image:
```bash
docker build . -t ly-homework
```

2. Run container:
```bash
# If you want mounted project:
docker run -p 4000:80 --name ly-homework --mount type=bind,source="$(pwd)",destination=/var/www/html ly-homework
# If you don't:
docker run -p 4000:80 --name ly-homework ly-homework
```

3. Start nginx:
```bash
docker exec -u root ly-homework /etc/init.d/nginx start
```

Task 1: Even fridays
====================
Execute it as Symfony command:

![Image](./docs/even-fridays.png)

With Docker:
```bash
docker exec ly-homework ./bin/console ly-homework:even-fridays
```

Task 2: Flip & resize image
===========================
Follow screenshots:

![Image](./docs/img-flip-1.png)

![Image](./docs/img-flip-2.png)

![Image](./docs/img-flip-3.png)

![Image](./docs/img-flip-4.png)

Task 3: Random user by letter
============================
Execute it as Symfony command:

![Image](./docs/random-user-by-letter.png)

With Docker:
```bash
docker exec ly-homework ./bin/console ly-homework:random-user-by-letter
```