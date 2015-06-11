# PHP easy extend

[![Current build status image][build-image]][Current build status]

<!-- References -->

[build-image]: http://img.shields.io/travis/apishka/easy-extend/master.svg "Current build status for the develop branch"
[Current build status]: https://travis-ci.org/apishka/easy-extend

# Getting started

Some library has basic implementation of class you want extend and this library implements EasyExtend:
```php
<?php

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
<?php

class My_Library_User_Implementation extends Library_User_Implementation
{
}
```

One thing you have to do is create new instance of class using

```php
<?php

Library_User_Implementation::apishka(); // instanceof My_Library_User_Implementation
```
