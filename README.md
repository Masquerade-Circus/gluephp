Glue Masquerade Circus' version
==========================

With this version you can include the script in a subdir and will work from it.
Also, you will recive the matches as coma separated vars.
   
Example:
```php
   $urls = array(
		'/' => 'index',
		'/catalog' => 'catalog'
		'/catalog/(\w+)' => 'catalog'
    	'/catalog/(\w+)/(\w+)' => 'catalog'
   );
   
   class catalog {
        function GET($category = null, $item = null) {
    		if ($item !== null)
         	echo "Your requested an item named $item on the category $category " ;
 		else if ($category !== null)
         	echo "Your requested the category $category " ;
 		else
         	echo "Your requested the main catalog section" ;
        }
   }
   
   glue::stick($urls);
```


Glue
====

Author: Joe Topjian, joe@topjian.net

Glue is a simple PHP class that maps URLs to classes. The concepts are similar to web.py for Python.

Information on how to use Glue can be found at http://gluephp.com.

License
=======
Glue is licensed under a BSD license. See LICENSE file for further details.

Pull Requests
=============
Since creating and publishing GluePHP, I have received a lot of patches and pull requests. Each
modification is vastly different than the other.

GluePHP is a __very__ simple PHP script and there are an almost infinite amount of modifications
and alternative styles that can be applied to it. Because of this, I do not accept patches or
pull requests. All patches that I have received have had very good ideas, so I do not think it
would be fair to accept some patches and not others (since most are incompatible with each other).

GluePHP is BSD licensed. By all means, fork the code, hack it up as much as you want, and 
republish it. :)
