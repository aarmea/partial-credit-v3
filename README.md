# Partial Credit A Cappella

This repository contains the code behind Partial Credit's
[public-facing website](http://partialcredit.union.rpi.edu).

## Usage

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
[http://www.dev-site.com:8080/][local]. When you're done, run
`vagrant suspend` to stop the virtual machine.

The Vagrant configuration is based on the LAMP stack at
[https://github.com/ymainier/vagrant-lamp][lamp].

[virtualbox]: https://www.virtualbox.org/
[vagrant]: http://www.vagrantup.com/
[local]: http://www.dev-site.com:8080/
[lamp]: https://github.com/ymainier/vagrant-lamp

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

    * Compass will begin watching the `scss` directory and will automatically
      compile `.scss` files to `.css` files in the "stylesheets" directory.
    * To quit, press `Ctrl-C`.

#### Upgrading

If you'd like to upgrade to a newer version of Foundation down the road just
run `bower update`.
