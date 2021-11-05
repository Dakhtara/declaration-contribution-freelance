# Declaration contribution Freelance

## Configuration

You need at least :

- Docker
- Git

## Installation

Once you have cloned the repo, copy the .env file to .env.local and make changes to your needs

Build containers

```
docker compose build
```

Launch containers

```
docker compose up -d 
```

Create some keypair for the jwt bundle
```
php bin/console lexik:jwt:generate-keypair
```


If you need to connect to the php container in sh :

```
docker compose exec php sh
```

The command below reset all the dbb and load with the fixtures
```
make reset-db
```

## Tests

Please read/modify .env.test before launching test to be sure everything fits your environment.

For the first time you make test please launch the command below to make sure you have a DB setup for your test
environment

```
make test-full
```

Then for usual test you can launch this command without wiping all your database

```
make test
```
