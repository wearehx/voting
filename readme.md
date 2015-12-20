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
The application authenticates users via Facebook Login. You'll need to create an application and set the appropriate values. Additionally, you should setup a webhook to `{url}/webhook/user` on `name` and `email` changes. Set the verify token you define in `FACEBOOK_VERIFY_TOKEN`. You also need to ensure your callback URL (`{url}/auth/facebook/callback`) is whitelisted for your application.

#### Environment Variables
You'll need to set the following environment variables in `.env` if not set in the web server's environment:
* `APP_KEY`: A random, 32 character string you can generate with `php artisan key:generate`.
* `FACEBOOK_APP_ID`
* `FACEBOOK_APP_SECRET`
* `FACEBOOK_CALLBACK_URL`: The URL of your application, followed by `/auth/facebook/callback` (ex. `https://test.ian.sh/auth/facebook/callback`).
* `FACEBOOK_VERIFY_TOKEN`: The verify token you set when creating the webhook.
* `NUM_ADMINS`: The number of admins to be elected.

#### Term Setup
Ensure you have migrated the database with `php artisan migrate` before proceeding.

To create the first term, you will need to backdate a previous term by running `php artisan term:create year month day`. Since terms are three months long, you want to take the date you want the next term to start on and subtract three months. Then, input that date as the three arguments to the command (if the next term should start on 12/19/2015, run `php artisan term:create 2015 9 19`). You then need to create your next term with the same command, but without subtracting three months (with the same example, the command would be `php artisan term:create 2015 12 19`).

New terms will automatically be created after this, assuming the scheduler [is properly setup](http://laravel.com/docs/5.1/scheduling#introduction).

#### Heroku Scheduler
If the application is running on Heroku, add the [Scheduler](https://elements.heroku.com/addons/scheduler) addon and set the command `php artisan schedule:run` to run every ten minutes.

### Contributing
You'll need to `npm install` our build dependencies and run `gulp --production` if you modify the SASS stylesheet. Changes can be proposed in a PR with a clear purpose and clear commit messages. Do note that merging into this repository is frozen during elections (two weeks from the next term's start date) except for security and critical bug fixes.

Additionally, you should read `contributing.md` and `todo.md`.
