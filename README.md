
# MLM Solution

This MLM solution has six level of payments.\
Levels are made using tree data structure(clusure table) which makes it better than all the recursive solutions out there.


## Features

- Activation Fee
- Level payments (all through level six)
- No central account but all payment request goes through the administrator
- Fast Tree Structure

## Usage

- clone this repository
- `cd [project-directory]`
- `composer install`
- create a `.env` file, copy all text in `.env.example` into the `.env` file and add your configurations.
- `php artisan key:generate`
- create your mysql database, and run the `/model.sql`script
- `php artisan serve`

TIP: You can change monetary variables on base controller `app/Http/Controllers/Controller.php` :metal: .\

If you need further help DM [ndiecodes](https://twitter.com/ndiecodes) on twitter.


## How do I thank you?

You could star the repository or send a thank you message to [ndiecodes](https://twitter.com/ndiecodes) on twitter.

## Licensing

* Copyright © 2019  [ndiecodes](https://twitter.com/ndiecodes)
* Licensed under MIT

