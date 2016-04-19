# GoSizzle.io

## Table of Contents
1. [Set Up](#set-up)
1. [Branching Strategy](#branching)
1. [Frontend Direction](#frontend)
1. [Testing](#testing)
1. [Deployment](#deployment)

## <a id="set-up"></a>Set Up

### URLs
(hosted on AWS)
- production: [www.gosizzle.io](https://www.gosizzle.io/)
- staging: [dev.gosizzle.io](http://dev.gosizzle.io)


### Github

Make sure you have access & set your project remote

    git remote add github git@github.com:GiveToken/GiftBox.git

*this assumes ssh; you could use `https://github.com/GiveToken/GiftBox.git` instead of `git@...` for https if you prefer*

You'll also need to

    cp config/credentials.php.example config/credentials.php

replacing the default credentials with whatever your choices are for local development,


### <a id="database"></a>MySQL Database

- Download and install [MySQL workbench](https://www.mysql.com/products/workbench/).

To create a local instance of the S!zzle database, use MySQL Workbench's Schema Transfer Wizard.

### AWS

If you'll be testing AWS, you'll need to create `~/.aws/credentials` and enter the following:

    [sizzle]
    aws_access_key_id = AWS_ACCESS_KEY_ID
    aws_secret_access_key = AWS_SECRET_ACCESS_KEY

with your specific credentials.

### Apache

If on a Mac, you can update `/etc/apache2/extra/httpd-vhosts.conf` to include something like

    <VirtualHost *:80>
        ServerAdmin username@gosizzle.io
        ServerName gosizzle.local
        ServerAlias *.gosizzle.local
        DocumentRoot "/Library/Webserver/Documents/GiftBox/public"

        <Directory "/Library/Webserver/Documents/GiftBox/public">
            Options -Indexes +FollowSymLinks +MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
    </VirtualHost>

and restart Apache. Then modify `/etc/hosts` to include

    127.0.0.1       gosizzle.local
    127.0.0.1       api.gosizzle.local

### <a id="composer"></a>Composer

[Composer](https://getcomposer.org/) is the PHP package manager used to bring in
3rd party PHP code. Once you have it in installed, cd to the project directory and
run

    composer install

which will create everything you need in the untracked vendor directory.

### <a id="bower"></a>Bower

[Bower](http://bower.io/) is a package manager used to bring in Polymer
components. Once you have it in installed, cd to the project directory and
run

    bower install

which will create everything you need in the untracked components directory.

### Optimization

Polymer's polybuild, YUI compressor & json-minify are tools optimize & minify an
app's code during the build process

    npm install

NB: polybuild treats PHP like a comment and removes it.

## <a id="branching"></a>Branching Strategy

### Basic Tenets

1. All code on the `master` branch will always be production-ready. If it is not production-ready it should not be on `master`
2. The `develop` branch is not a sacred cow. It will be wise to occasionally blow away the `develop` branch and create a new one off of master.
3. Create branches off of `develop` (except hotfixes, create those off of `master`)
using the following convention:
  - `feature`, `bug`, or `hotfix`
    - `feature` is new functionality
    - `bug` is unexpected behavior in exisiting functionality
    - `hotfix` is a `bug` of the highest priority-- e.g. the site is down or Give Token is leaking sensitive data.
    - Exmples:
      - `bug/37-icons-broken-in-ie`
      - `feature/236-user-can-add-avatar`
      - `hotfix/76-repair-payment-gateway`
  - Forward slash
  - The GH issue number
  - dashes, never underscores
  - A meaningful and short description of the branch, generally related to the title of the GH issue
4. All code gets merged into `master` via pull request (PR).
5. All code get approved by the project lead before being merged via PR.
6. Commit messages begin with a present-tense verb, referencing the issue number,  
and describe some combination of what was done, where it was done, and why.
7. NEVER EVER EVER merge `develop` into `master`.

### Handling Merge Conflicts

Github has a great reference [here](https://help.github.com/articles/resolving-a-merge-conflict-from-the-command-line/).


## <a id="frontend"></a>Frontend Direction

### Directory structure
Javascript source exists in `/js`.
Third party files that are _not_ loaded by one of our package managers for
whatever reason should be dropped into `js/vendor`. This can be considered a
big "do not manipulate these files" alert. Project tasks and task configuration
lives in `/js/gulp`.

### The Application Object
`/js/Sizzle.js` is the base Application object and namespace. All other
functionality hangs off this parent object.

#### Events
In addition to standard DOM events, `Sizzle` will emit the following events on `document`:

* `bootstrap` - Triggered once all scripts are loaded in. This event should be
considered the entry point of the frontend application.

#### Components
Components are self-contained pieces of functionality that manipulate the DOM or
generate events. A good example is a custom input field, or a modal system.

#### Controllers
Controllers are generally 1 per page, and are responsible for configuring
Components on any given page. Easiest way to create one of these is to use the
factory method `Sizzle.Controllers.create(id, callback);`. It will ensure that your
callback is not called unless an element with the provided id is on the page at `bootstrap`.

### Configuring The Build Process
There are several `build` configurations in `/js/gulp/config.js`. Each one of
these has four sections of files:

* vendor_js
* vendor_css
* js
* css

The build process concatenates all scripts and style together (vendor first),
respectively, then compresses them and writes them to `public/{type}/dist`.

As a second pass, anything in `config.minify_and_migrate` is minified _without_
concatenation then moved to `public/{type}`.

It is a goal of this project to get anything in the `minify_and_migrate` list
into one of the appropriate builds.

*Never manipulate the public directory files directly.* These are your build
files. If changes need to be made to a particular file, they should be done in
the source files and then rebuild. Keeping this organized appropriately will
ensure that front end code is easily traversable and scripts are generally easily
identifiable.

### A matter of style
#### Javascript
// TODO: PUT ESLINT INTO PROJECT, TALK ABOUT ESLINT HERE.
// ALSO TALK ABOUT OO AND STYLE IN JS.

#### CSS
New css (and refactored legacy css) should follow [BEM syntax](https://css-tricks.com/bem-101/) (Block - Element - Modifier).

This is a neat way to organize your classes so that your styles are portable, you have shallow specificity, and styles
are easy to read and apply.

As a convention, at the top of each file should be a BEM map, that lays out all of the possible class variations for
this particular block. It would look something like this:

```
//  .Button
//    --disabled
//    --small
//    __label
//    __icon
```

In this example `.Button` is our block, but we can see that a button can have a `.Button__label` and a `.Button__icon`.
It can also have the modifier classes `.Button--disabled` or `.Button--small`.

### Refactoring Legacy Code
* Step one of the refactor is to separate vendor files from Sizzle files. Vendor files can be concatenated in the order
that they're loaded.
* Step two is to one by one alter sizzle files so that they can be included in a build. Legacy files are generally
written in a way that assumes that that logic will need to run immediately. By giving these scripts just a _little_ more
information, you can ensure they only run _when they need to_.
    * For javascript, the Controller factory is a good way to lock functionality down to an element. By passing a callback
    along with an HTML ID to `Sizzle.Controller.create()`, you defer execution of that method until the application sees
    an element with that ID at `bootstrap`.
    * For css, you may need to refactor the classes and the file into BEM syntax. If you just _can't_ do that, a quick way
    to ensure that it can be included is to make sure that your selectors are specific enough to stand on their own. If
    you have a script that styles a `.ClassName` element a different way than you have elsewhere in the app, Don't just
    override `.ClassName`, create a modifier class that sits _with_ `.ClassName` and style _that_.
    `.ClassName.ClassName--alternative`

## <a id="testing"></a>Testing

Presuming you have set up [Composer](#composer), then PHPUnit will be available
in your /vendor/bin directory. You'll need to setup your local parameters by

    cp src/Tests/local.php.example src/Tests/local.php

and making any necessary changes to `local.php`. To run all the tests, just reference the
configuration file:

    phpunit --bootstrap src/tests/autoload.php -c tests.xml

To also investigate the code coverage of the tests, you'll need the
[Xdebug PHP extension](http://xdebug.org/docs/install).
Make sure you put any unit tests in the `src/tests` directory and name them like
MyAwesomeTest.php.

For JavaScript testing, run the following command

    npm run test

## <a id="deployment"></a>Deployment

#### `develop` -> staging site

#### `master` -> production

### Build Script
The build script (`build.sh`) runs unit tests, warns you of any untracked or
uncommited files, minifies JavaScript & CSS, and Polybuilds the token.
The full set of options is available in the help menu

    ./build.sh -h

The important caveat is that this script was written on OSX and may not work on
Cygwin or your favorite Windows version of Linux.

### <a id="deploy-staging"></a>Deploy to Staging

Any push to `develop` is automagically pulled onto the staging server except
during the QA period for new releases.

### <a id="deploy-production"></a>Deploy to Production

Log into the production webserver and

    git branch YYYYMMDD.backup
    git pull origin master
    composer install
