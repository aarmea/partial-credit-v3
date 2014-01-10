# Partial Credit A Cappella

This repository contains the code behind Partial Credit's
[public-facing website](http://partialcredit.union.rpi.edu).

## Usage

### Quickstart for members

Most of the functionality of the site is available in the members section, which
is accessible by clicking the "member login" button on the bottom-right corner
of each page. You will be asked for your RCS credentials. This is the part of
your RPI email before the `@rpi.edu`, so if you're `asdfjk@rpi.edu` your RCS ID
is `asdfjk`. Your password is the same one as used for Webmail.

### Deployment for production

TODO

## Code

### Testing locally

The repository contains a Vagrant configuration for a server virtual machine
that can run locally within your computer running Windows, Mac OS X, or Linux.
To use it, download and install [VirtualBox][virtualbox] and
[Vagrant][vagrant], then in a terminal `cd` to this repository and run
`vagrant up`. Once Vagrant finishes starting the virtual machine, add

    127.0.0.1 www.dev-site.com dev-site.com dev.dev-site-static.com

to your `hosts` file, open a Web browser and navigate to
<http://www.dev-site.com:8080/>. When you're done, run `vagrant suspend` to stop
the virtual machine.

The Vagrant configuration is based on the LAMP stack at
<https://github.com/ymainier/vagrant-lamp>.

[virtualbox]: https://www.virtualbox.org/
[vagrant]: http://www.vagrantup.com/

You'll also need to follow the steps for both frontend and backend
initialization below.

### Front-end design and development

On the front-end, this site uses Foundation with Compass.

#### Requirements

  * Ruby 1.9+
  * [Node.js](http://nodejs.org)
  * [compass](http://compass-style.org/): `gem install compass`
  * [bower](http://bower.io): `npm install bower -g`

It should be simple to install Ruby and Node.js on Linux and Mac OS X using your
preferred package manager. I have not tested front-end development on Windows.

#### Quickstart

  1. `git clone` this repository somewhere.
  2. `cd` to "public".
  3. Install the latest version of Foundation by running `bower install`.
  4. When you're working on the site, run `compass watch`.

    * Compass will begin watching the "scss" directory and will automatically
      compile `.scss` files to `.css` files in the "stylesheets" directory.
    * To quit, press `Ctrl-C`.

#### Upgrading

If you'd like to upgrade to a newer version of Foundation down the road just
run `bower update`.

### Back-end dependencies

On the back-end, this site's dependencies are managed using
[Composer][composer], which can be installed using their
[installation guide][composer-install]. This requires `php` 5.0+ and `curl` on
your system.

[composer]: http://getcomposer.org/
[composer-install]: http://getcomposer.org/doc/01-basic-usage.md#installation

#### Quickstart

1. Install Composer into the "public" directory.

        curl -sS https://getcomposer.org/installer | php

2. Use Composer to install the required dependencies. You may need a GitHub
   account for this step.

        php composer.phar install
