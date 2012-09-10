FogBugz Geckoboard Widgets
---------------------------------------

This site provides data from FogBogz to drive a collection of widgets for use
in [Geckoboard][geckboard]. 

## Development

I develop with Vagrant, commit, and then host it on an external site where I can
then test with Geckboard. To see a local version of this, you'll need to setup
[Vagrant][vagrant] and then `vagrant up`.

## Installation

This app is build on top of slim, and packages are managed with
[Composer][composer]. If you are working on an OSX machine, I highly recommend
installing [Composer with Brew][brew]. Once you've done that it, run
`composer install` and then access the site. If you're on Vagrant, it'll be at
[33.33.33.100](http://33.33.33.100).

## Geckoboard Setup

Please see the comments in the /routes files about how to setup the geckoboard
widgets in the proper format


## Notes

* [HTML Tags in custom widgets](http://support.geckoboard.com/entries/20124937-html-tags-allowed-in-the-custom-text-widget)
* [Custom Widget Help](http://docs.geckoboard.com/custom-widgets/beginners-guide.html)
* [Geckboard Styles](https://insight.geckoboard.com/css/dashboard.css)


[geckboard]: http://www.geckoboard.com/
[composer]: https://github.com/composer/composer
[brew]: https://github.com/composer/composer#global-installation-of-composer-via-homebrew
[vagrant]: http://vagrantup.com/v1/docs/getting-started/index.html