## Voting
[![Code Climate](https://codeclimate.com/github/wearehx/voting/badges/gpa.svg)](https://codeclimate.com/github/wearehx/voting)   

The voting application for Hackers, built using PHP 7, Laravel 5.1, and PostgreSQL.

**Warning:** This code has not been reviewed by anyone. It has no unit tests (yet), and has not been deployed to production (yet).

### Setup
You'll need Composer to get started. Once you have that, it's a matter of cloning the repository, installing the dependencies, and setting up the database.
```
git clone https://github.com/wearehx/voting hx-voting && cd hx-voting
composer install
cp .env.example .env && $EDITOR .env # http://laravel.com/docs/5.1/database#configuration
php artisan migrate
php artisan serve
```
#### Facebook Login
The application authenticates users via Facebook Login. You'll need to create an application and set the appropriate values. Additionally, you should setup a webhook to `{url}/webhook/user` on `name` and `email` changes. Set the verify token you define in `FACEBOOK_VERIFY_TOKEN`.

#### Environment Variables
You'll need to set the following environment variables in `.env` if not set in the web server's environment:
* `APP_KEY`: A random, 32 character string you can generate with `php artisan key:generate`.
* `FACEBOOK_APP_ID`
* `FACEBOOK_APP_SECRET`
* `FACEBOOK_CALLBACK_URL`: The URL of your application, followed by `/auth/facebook/callback` (ex. `https://test.ian.sh/auth/facebook/callback`).
* `FACEBOOK_VERIFY_TOKEN`: The verify token you set when creating the webhook.
* `NUM_ADMINS`: The number of admins to be elected.

### Contributing
You'll need to `npm install` our build dependencies and run `gulp --production` if you modify the SASS stylesheet. Changes can be proposed in a PR with a clear purpose and clear commit messages. Do note that merging into this repository is frozen during elections (two weeks from the next term's start date) except for security and critical bug fixes.

Additionally, you should read `contributing.md` and `todo.md`.
