#narrator/narrator

[![Travis CI](https://travis-ci.org/mleko/narrator.svg?branch=master)](https://travis-ci.org/mleko/narrator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mleko/narrator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mleko/narrator/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mleko/narrator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mleko/narrator/?branch=master)

Small and simple Event Bus library.

Narrator allows communication between components without requiring the component to explicitly depend on each other.

##Installation

Using [Composer](http://getcomposer.org/):

```sh
$ composer require narrator/narrator
```

##Basic usage

```php
// Simple event object
class UserRegistered {
    private $userId;
    
    private $userName;
    // ...event data, constructor, getters
}
// Sample listener
class UserRegisteredListener implements Listener {

    public function handle($event, Meta $meta){
        // send email, update model, etc
    }
}

// create EventBus which will be responsible for managing events and listeners
$eventBus = new BasicEventBus(new ClassNameExtractor());

// create listener instance
$listener = new UserRegisteredListener(...);
// and register it in bus
$eventBus->subscribe(UserRegistered::class, $listener);

// create event
$event = new UserRegistered(...);
// and `emit` it to listeners
$eventBus->emit($event);
```

##Testing
To run unit tests use PHPUnit
```
$ ./vendor/bin/phpunit
```
