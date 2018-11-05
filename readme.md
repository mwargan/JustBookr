# JustBookr

<img src="https://justbookr.com/images/logoDark.svg" width="48"/>

[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://justbookr.com)

JustBookr is a platform that allows students to trade books at their university.

This code has been published to help others see live examples of websites built using VueJS and Laravel, as well as to allow the community to better this platform and add their contributions; so commit away ;)!

## Installation

Clone this repositiory and run the following in the root directory of the project:
```sh
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev
```
And that should do it!

Run JustBookr locally with MAMP PRO on `https://justbookr.dev` (or use `php artisan serve`). Please note that Google apparently bought the .dev domain so if you're not using https Chrome will give you all sorts of errors - avoid this by using https or don't use .dev.

When developing, use hot-reloading with `npm run watch`.

## Testing and live deployment

Currently, JustBookr is hosted using Laravel Forge on an AWS EC2 instance. If you are using Laravel Forge, there is no extra configuration needed.

Previously (and possibly in the future when the app grows), JustBookr was hosted on Elastic Beanstalk. To deploy with Elastic Beanstalk I have made additional configuration files for Elastic Beanstalk, but because they contain sensitive data, I have excluded them from GitHub. Feel free to contact me to get a template of the EB files!

### Testing
```sh
NPM run production
```
Go to `public/sw.js` and move `workbox.routing.registerNavigationRoute('/https:\/\/justbookr.com/');` to the end of the file (if it stays there the whole thing messes up... if anyone has any ideas I'm listening :P)
```sh
vendor/bin/phpunit
php artisan dusk
```

### Deployment
Make sure you have done the previous testing step before.
```sh
git add .
git commit -m "Commit Message"
git push origin master
# DONE - use the next step only if on Elastic Beanstalk
eb deploy JustBookr
```

A little while after deployment (after all CI's have finished), use `git pull origin master` to get the latest commits that may have been pushed automatically by StyleCI.

## Platform Features

Currently, JustBookr allows users to:
- Add new books to the database
- Post books for sale at a given university
- Search for books at a given university
- Buy books, where users choose a time and place to meet (no payment system online)
- Rate their meetings with buyers and sellers
- Share their posts on Facebook

And a few other little things. Check out the current website! It's free :P!

## Official Documentation

Documentation for JustBookr isn't yet available. API uses CRUD operations - routes available in `api.php`.

Most endpoints support `GET` `POST` `PUT` and `DELETE` requests. Others only allow the `GET` request.

## Security Vulnerabilities

If you discover a security vulnerability within JustBookr, please send an e-mail to support@justbookr.com. All security vulnerabilities will be promptly addressed.

## Contributions

Contributions are very warmly welcomed! When adding a contribution, please also add a small description of the changes made.

## License

This version of JustBookr is open-source code that's licensed under the [MIT license](http://opensource.org/licenses/MIT).

###### This website is live at justbookr.com
