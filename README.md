# Instructions

## Log parser

1. perform the migration while in the container

```
  php bin/console doctrine:migrations:generate
```

2. create a test database (could be moved to docker config)

```
  php bin/console doctrine:database:create --env=test
```

3. perform the migration while in the container

```
  php bin/console doctrine:migrations:migrate --env=test
```

4. to test the parsing log file, place the file in the /logs directory under the name logs.txt


5. finally, we can run the parser

```
  php bin/console app:parse-log-file
```

## Log api

To test the api, send a request to endpoint: http://localhost:9002/api/log, the result can be filtered by sending filters in the body, e.g:

```
  {
    "serviceNames": ["USER-SERVICE", "INVOICE-SERVICE"],
    "startDate": "2016-01-01 00:00:00",
    "endDate": "2022-12-31 23:59:59",
    "statusCode": 201
}
```

# L1 Challenge Devbox 

## Summary

- Dockerfile & Docker-compose setup with PHP8.1 and MySQL
- Symfony 5.4 installation with a /healthz endpoint and a test for it
- After the image is started the app will run on port 9002 on localhost. You can try the existing
  endpoint: http://localhost:9002/healthz
- The default database is called `database` and the username and password are `root` and `root`
  respectively
- Makefile with some basic commands

## Installation

```
  make run && make install
```

## Run commands inside the container

```
  make enter
```

## Run tests

```
  make test
```
