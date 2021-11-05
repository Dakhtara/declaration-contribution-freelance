# Declaration contribution Freelance

## Configuration

You need at least :

- PHP 8.0
- Git
- Composer

## Installation

Once you have cloned the repo, copy the .env file to .env.local and make changes to your needs

Then install the dependencies :

```
composer install
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
