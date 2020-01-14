
# MLM Solution

This MLM solution has six level of payments.\
Levels are made using tree data structure(clusure table) which makes it better than all the recursive solutions out there.


## Features

- Activation Fee
- Level payments (all through level six)
- Paystack payments gateway 
- Fast Tree Structure

## Usage

- clone this repository
- `cd [project-directory]`
- `composer install`
- create a `.env` file, copy all text in `.env.example` into the `.env` file and add your configurations.
- `php artisan key:generate`
- create your mysql database, and run the `/model.sql`script
- `php artisan serve`

TIP: Change user role from "user" to "admin" in `users table`, after registering your first user; to see full admin privileges. 

TIP: You can change monetary variables on base controller `app/Http/Controllers/Controller.php` :metal:

If you need further help DM [ndiecodes](https://twitter.com/ndiecodes) on twitter.


## How do I thank you?

You could star the repository or ![Foo](https://res.cloudinary.com/iamndie/image/upload/v1578985963/patreon2_twips4.png)](https://www.patreon.com/ndiecodes)

## Licensing

* Copyright © 2019  [ndiecodes](https://twitter.com/ndiecodes)
* Licensed under MIT

