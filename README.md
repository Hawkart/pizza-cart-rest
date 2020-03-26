# Pizza cart rest

## Installation

- `git clone https://github.com/Hawkart/pizza-cart-rest`
- `composer install`
- Copy `.env.exmple` to `.env`. Edit `.env` to set your database connection details and `APP_URL` (the url to your Laravel application)
- (When installed via git clone or download, run `php artisan key:generate` and `php artisan jwt:secret`)
- `php artisan migrate`

## Configure deploy (Heroku)

- `heroku login`
- The popup of login will appear, click on Login button
- Procfile with all needed commands is already in package
- `heroku create` - will get your app name created by Heroku and your repository name
- Add configuration in Heroku (Settings->Reveal Config Vars) base on `.env` file
- `git add .`
- `git commit -m “Your Commit”`
- `git push heroku master`
- `heroku run php artisan migrate`