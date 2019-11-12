
## Obviux new developer test case

**Requirements**
* Composer
* PHP >= 7.0.0
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Sqlite PHP Extension

**Getting started**

- run `composer install`
- create a `.env` file with:
```
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:i7WQo9iUSQud+Oi90HGJzonE4w+SPaV3NI3AMBnee3A=
APP_URL=http://localhost
DB_CONNECTION=sqlite
```

Create a sqlite file:

```
touch database/database.sqlite
```

Run migrations and seed database:

```
php artisan migrate --seed
```


Start localhost server (Optional: Feel free to use Nginx, homestead, VB, docker etc.):

```
php artisan serve
```

## Purpose

The purpose of this test case is to get your feet wet in a small contained code base. It is based on the version of
laravel we use here but in a completely new project, so if you run into any problems on how to do stuff, you can always
start out by looking it up on the internet.
There are a number of TODO's around the codebase you can try to tackle, but it is not required that you do all of them.

Try to make commits to git as often as you would normally do, to show the progress in your work.

There are todo's the following places:

__app/Http/Controllers/CustomerController.php__
 - Implement creating an invoice as you see fit. There are 4 model classes in play: Customer, Agreement, Invoice, Delivery.
   The idea is that a customer should get an invoice for deliveries pr. month or week. And the invoice amount should equal 
   the sum of deliveries->count times the unit price on the agreement, within the period set by the agreement type.
   
__tests/Unit/CustomerTest.php__
 - Here is a couple of simple unit tests you can use to validate that you create the invoice correctly.
 
__resources/views/__
 - If you like, you can try to finish the views + controllers to have a sort of working application.

   A quick guide to where stuff is:
   - View files: resources/views/
   - Controllers: app/Http/Controllers/
   - Routes: routes/
 
__tests/Feature/ExampleTest.php__
 - Here is a feature test you can use to test if the ui contains the elements you expect, and that clicking around does what you expect. 
