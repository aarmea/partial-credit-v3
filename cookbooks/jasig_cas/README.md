Description
===========

This cookbook provides an easy way to install the Jasig CAS client for PHP, an
authentication system commonly used in colleges and universities.

More information?
<http://www.jasig.org/cas/>

Requirements
============

## Cookbooks:

* php-pear

## Platforms:

* Ubuntu
* Debian
* RHEL
* CentOS
* Fedora

Attributes
==========

* `node['jasig_cas']['url']` - Location of the source

Usage
=====

1. include `recipe[jasig_cas]` in a run list
2. tweak the attributes via attributes/default.rb
3. or override the attribute on a higher level (http://wiki.opscode.com/display/chef/Attributes#Attributes-AttributesPrecedence)

References
==========

* [Jasig CAS PHP installation guide](https://wiki.jasig.org/display/CASC/phpCAS+installation+guide)

License and Authors
===================

Author: Albert Armea <albert@albertarmea.com>

Copyright: 2013, Albert Armea and contributors

Unless otherwise noted, all files are released under the MIT license,
possible exceptions will contain licensing information in them.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
