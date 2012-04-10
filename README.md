Dot Access Data
===============

Given a deep data structure, access data by dot notation.


Requirements
------------

 * PHP (5.3+)


Usage
-----

    use Dflydev\DotAccessData\Data;
    
    $data = new Data;
    
    $data->set('a.b.c', 'C');
    $data->set('a.b.d', 'D1');
    $data->append('a.b.d', 'D2');
    $data->set('a.b.e', array('E0', 'E1', 'E2'));
    
    // C
    $data->get('a.b.c');
    
    // array('D1', 'D2')
    $data->get('a.b.d');
    
    // array('E0', 'E1', 'E2')
    $data->get('a.b.e');


License
-------

This library is licensed under the New BSD License - see the LICENSE file
for details.


Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.