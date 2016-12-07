jAlert for Jaxon
================

This package implements javascript alert and confirmation dialogs in Jaxon applications using the jQuery jAlert plugin.
http://flwebsites.biz/jAlert/.

Features
--------

- Enrich the Jaxon response alert and confirmation dialogs.
- Automatically insert the Javascript and CSS file of the jAlert library into the HTML page.

Installation
------------

Add the following line in the `composer.json` file.
```json
"require": {
    "jaxon-php/jaxon-jalert": "1.0.*"
}
```

Or run the command
```bash
composer require jaxon-php/jaxon-jalert
```

Configuration
------------

By default the plugin loads the version 4.5.1 of Javascript and CSS files from the Jaxon website.

- https://lib.jaxon-php.org/jAlert/4.5.1/jAlert.min.js
- https://lib.jaxon-php.org/jAlert/4.5.1/jAlert.css

This can be disabled by setting the `assets.include.jalert` option to `false`.

Usage
-----

This example shows how to print a notification.
```php
class HelloWorld
{
    public function sayHello($text)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'innerHTML', $text);

        // Print a notification with Bootbox
        $response->jalert->success("You did it!!!");

        return $xResponse;
    }
}
```

The `jalert` attribute of Jaxon response provides the following functions.
```php
public function info($message, $title = null);
public function success($message, $title = null);
public function warning($message, $title = null);
public function error($message, $title = null);
```

This plugin can also be used to add confirmation questions to Jaxon calls.
```php
    <button onclick="<?php echo jr::call('HelloWorld.sayHello', jr::html('DemoDiv'))->confirm('Really?') ?>">Click Me</button>
```

Contribute
----------

- Issue Tracker: github.com/jaxon-php/jaxon-jalert/issues
- Source Code: github.com/jaxon-php/jaxon-jalert

License
-------

The project is licensed under the BSD license.
