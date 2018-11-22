[![Build Status](https://travis-ci.org/anigrab/wp-anigrab.svg?branch=master)](https://travis-ci.org/anigrab/wp-anigrab)

### Requirement

- PHP >= 7.0

-  [composer](https://getcomposer.org/) (optional)

- [wp-cli](https://make.wordpress.org/cli/handbook/installing/) (optional)

### Installation

in terminal, run this command
```
$ composer create-project grei/wp-anigrab path-to-wp-plugins/wp-anigrab --no-dev
$ cd path-to-wp-plugins/wp-anigrab && composer dump-autoload -o
$ wp plugin activate wp-anigrab

```
or download installable.zip from [release](https://github.com/anigrab/wp-anigrab/releases)


### Usage

place this shortcode-like anywhere in your post  [anigrab=**id**]**template**[/anigrab] or [mangrab=**id**]**template**[/mangrab]

-  **id:** myanimelist anime/manga id

-  **template:** use  **dump** for auto parse or template engine syntax, e.g
```
[anigrab=497]
title: {{title}}
etc
[/anigrab]
or
[mangrab=44]
title: {{title}}
etc
[/mangrab]
```

### Dependency

- [Jikan](https://jikan.moe)

- [mustache](https://packagist.org/packages/mustache/mustache)

### TO DO

- [ ] implement [imposter](https://github.com/TypistTech/imposter)

- [ ] add more features

