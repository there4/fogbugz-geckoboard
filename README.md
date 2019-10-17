# FogBugz Geckoboard Widgets

> **DEPRECATED** This project is no longer maintained. If you are interested in maintaining this project, please open an issue.

This site provides data from FogBogz to drive a collection of widgets for use
in [Geckoboard][geckboard].


* [Homepage][home]
* Author: [Craig Davis][author] of [There4][there4]


## Development

I develop with Vagrant, commit, and then host it on an external site where I can
then test with Geckboard. To see a local version of this, you'll need to setup
[Vagrant][vagrant] and then `vagrant up`.

## Private Routes

If you create route files in `./routes/` with a leading underscore, a gitignore
file rule will ignore them from the repo. This should make it easier to add new
private routes to your clone or branch without having to clutter up the ignore
file with rules for everyone.

## Installation

This app is build on top of [Slim][slim], and packages are managed with
[Composer][composer]. If you are working on an OSX machine, I highly recommend
installing [Composer with Brew][brew]. Once you've done that, run
`composer install` and then access the site. If you're on Vagrant, it'll be at
[33.33.33.100](http://33.33.33.100).

## Geckoboard Setup

* Developer List
* Kiln RSS
* Case Counts for lists

## Notes

* [HTML Tags in custom widgets](http://support.geckoboard.com/entries/20124937-html-tags-allowed-in-the-custom-text-widget)
* [Custom Widget Help](http://docs.geckoboard.com/custom-widgets/beginners-guide.html)
* [Geckboard Styles](https://insight.geckoboard.com/css/dashboard.css)

[author]: mailto:craig@there4development.com
[there4]: http://there4development.com/#home
[home]: https://github.com/there4/fogbugz-geckoboard
[geckboard]: http://www.geckoboard.com/
[composer]: https://github.com/composer/composer
[brew]: https://github.com/composer/composer#global-installation-of-composer-via-homebrew
[slim]: http://www.slimframework.com/
[vagrant]: http://vagrantup.com/v1/docs/getting-started/index.html

***
