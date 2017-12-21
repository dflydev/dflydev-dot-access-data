Dot Access Data
===============

Given a deep data structure, access data by dot notation.


Requirements
------------

 * PHP (7.0+)

> For PHP (5.3+) please reffer to version `1.0`.


Usage
-----

Abstract example:

```php
use Dflydev\DotAccessData\Data;

$data = new Data;

$data->set('a.b.c', 'C');
$data->set('a.b.d', 'D1');
$data->append('a.b.d', 'D2');
$data->set('a.b.e', ['E0', 'E1', 'E2']);

// C
$data->get('a.b.c');

// ['D1', 'D2']
$data->get('a.b.d');

// ['E0', 'E1', 'E2']
$data->get('a.b.e');

// true
$data->has('a.b.c');

// false
$data->has('a.b.d.j');
```

A more concrete example:

```php
use Dflydev\DotAccessData\Data;

$data = new Data([
    'hosts' => [
        'hewey' => [
            'username' => 'hman',
            'password' => 'HPASS',
            'roles'    => ['web'],
        ],
        'dewey' => [
            'username' => 'dman',
            'password' => 'D---S',
            'roles'    => ['web', 'db'],
            'nick'     => 'dewey dman',
        ],
        'lewey' => [
            'username' => 'lman',
            'password' => 'LP@$$',
            'roles'    => ['db'],
        ],
    ],
]);

// hman
$username = $data->get('hosts.hewey.username');
// HPASS
$password = $data->get('hosts.hewey.password');
// ['web']
$roles = $data->get('hosts.hewey.roles');
// dewey dman
$nick = $data->get('hosts.dewey.nick');
// Unknown
$nick = $data->get('hosts.lewey.nick', 'Unknown');

// DataInterface instance
$dewey = $data->getData('hosts.dewey');
// dman
$username = $dewey->get('username');
// D---S
$password = $dewey->get('password');
// ['web', 'db']
$roles = $dewey->get('roles');

// No more lewey
$data->remove('hosts.lewey');

// Add DB to hewey's roles
$data->append('hosts.hewey.roles', 'db');

$data->set('hosts.april', [
    'username' => 'aman',
    'password' => '@---S',
    'roles'    => ['web'],
]);

// Check if a key exists (true to this case)
$hasKey = $data->has('hosts.dewey.username');
```


License
-------

This library is licensed under the New BSD License - see the LICENSE file
for details.


Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.
