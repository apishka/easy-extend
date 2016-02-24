# PHP easy extend

[![Current build status image][build-image]][Current build status]

<!-- References -->

[build-image]: http://img.shields.io/travis/apishka/easy-extend/master.svg "Current build status for the develop branch"
[Current build status]: https://travis-ci.org/apishka/easy-extend

# Getting started
## Extending classes
Some library has basic implementation of class you want extend and this library implements EasyExtend:
```php
class Library_User_Implementation
{
    /**
     * We have to include trait
     */
    use Apishka\EasyExtend\Helper\ByClassNameTrait;
}
```

One thing you have to do to extend this class and don't rewrite any library code, or check where new user class should pass is to extends that class:

```php
class My_Library_User_Implementation extends Library_User_Implementation
{
}
```

One thing you have to do is create new instance of class using

```php
Library_User_Implementation::apishka(); // instanceof My_Library_User_Implementation
```

All libraries can be easy extended for you custom project with your custom requirements. No need to require tons of code.

##Items routing
Create router and realize two methods:

```php
class My_Library_ItemsRouter extends \Apishka\EasyExtend\Router\ByKeyAbstract
{
    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        return $reflector->isSubclassOf('My_Library_ItemsInterface');
    }

    protected function getClassVariants(\ReflectionClass $reflector, $item)
    {
        return $item->getAliases();
    }
}
```

Create item:
```php
class My_Library_ItemApple implements My_Library_ItemsInterface
{
    public function getAliases()
    {
        return array(
            'apple',
            'red_apple',
        );
    }
}
```

Now you can get class by alias:
```php
var_dump(
    get_class(My_Library_ItemsRouter::apishka()->getItem('apple')
); // My_Library_ItemApple

var_dump(
    get_class(My_Library_ItemsRouter::apishka()->getItem('red_apple')
); // My_Library_ItemApple
```
Also you can extend your item:
```php
class My_Library_ItemRedApple extends My_Library_ItemApple
{
}

// after ./vendor/bin/easy-extend
var_dump(
    get_class(My_Library_ItemsRouter::apishka()->getItem('apple')
); // My_Library_ItemRedApple
```
