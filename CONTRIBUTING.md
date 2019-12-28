# Contributing

Contributions are welcome, and are accepted via pull requests. Please review these guidelines before submitting any pull requests.

## Guidelines

* Please follow the [PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).
* Ensure that the current tests pass, and if you've added something new, add the tests where relevant.
* Remember that we follow [SemVer](http://semver.org). If you are changing the behaviour, or the public api, you may need to update the docs.
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash](http://git-scm.com/book/en/Git-Tools-Rewriting-History) them before submitting.
* You may also need to [rebase](http://git-scm.com/book/en/Git-Branching-Rebasing) to avoid merge conflicts.

## Running Tests

You will need an install of [Composer](https://getcomposer.org) before continuing.

First, install the dependencies:

```bash
$ composer install
```

Then run phpunit:

> * DynamoDb local version: 2016-01-07_1.0
> * DynamoDb local schema for tests created by the [DynamoDb local shell](http://docs.aws.amazon.com/amazondynamodb/latest/developerguide/Tools.DynamoDBLocal.Shell.html) is located [here](dynamodb_local_schema.js)

Run the following commands:

```bash
$ java -Djava.library.path=./DynamoDBLocal_lib -jar dynamodb_local/DynamoDBLocal.jar --port 3000
# In a separate tab
$ ./vendor/bin/phpunit
```

or

```bash
composer --timeout=0 run dynamodb_local
# In a separate tab
composer run-script test
```
