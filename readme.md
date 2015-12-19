## Voting
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

### Contributing
You'll need to `npm install` our build dependencies and run `gulp --production` if you modify the SASS stylesheet. Changes can be proposed in a PR with a clear purpose and clear commit messages. Do note that merging into this repository is frozen during elections (two weeks from the next term's start date) except for security and critical bug fixes.

Additionally, you should read `contributing.md` and `todo.md`.
