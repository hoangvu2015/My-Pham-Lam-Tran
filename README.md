## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Current developing code is based on Laravel 5.1.23 (LTS)

## Table of contents

- [Installation](#installation)
    - [Server](#server)
    - [PHP](#php)
    - [MySQL](#mysql)
- [Solutions/Resources](#solutionsresources)
- [Contributing](#contributing)
  + [Step 1: Build database-level Data Model](#step-1-build-database-level-data-model)
  + [Step 2: Build application-level Data Model](#step-2-build-application-level-data-model)
  + [Step 3: Build Routes to lead user's requests to Controllers](#step-3-build-routes-to-lead-users-requests-to-controllers)
  + [Step 4: Build Controller to process user requests directed from Routes](#step-4-build-controller-to-process-user-requests-directed-from-routes)
  + [Step 5: Build Template](#step-5-build-template)
- [Extra Special Actions](#extra-special-actions)

## Installation

### Server

- Apache 2
    - Enable Mod Rewrite
- Install & Configure [Supervisor](http://laravel.com/docs/5.1/queues#supervisor-configuration) for Laravel queueing jobs (esp. Email functions)

### PHP
- PHP >= 5.6
- Enable Extensions:
    - [OpenSSL](http://php.net/manual/en/openssl.installation.php)
    - [PDO](http://php.net/manual/en/pdo.installation.php)
    - [Mbstring](http://php.net/manual/en/mbstring.installation.php)
    - [Tokenizer](http://php.net/manual/en/tokenizer.installation.php)
    - [File Information](http://php.net/manual/en/fileinfo.installation.php)
    - [Internationalization](http://php.net/manual/en/intl.installation.php)
    - [Client URL Library](http://php.net/manual/en/curl.installation.php)

If in Windows environment, remember to check enabled extensions in `php.ini` file (at `[PHP]` section). And when error with cURL SSL, copy this file [CACERT](https://www.dropbox.com/s/ouvx02mofj0en6w/cacert.pem?dl=0) to PHP installation folder `%PHP_INSTALLATION_FOLDER%\extras\ssl`

If in Linux, there is, perhaps, no need to include installed extensions in PHP configuration file.

### MySQL
- MySQL >=5.5
- Configuration (`my.ini` or `my.cnf` at section `[mysqld]`):

```php
innodb_file_format=BARRACUDA
innodb_large_prefix=ON
```

Those lines above help MySQL server work better with multi-language transaction database.

## Solutions/Resources

- [Laravel Docs](http://laravel.com/docs) ~ Embed Framework.
- [Mcamara/LaravelLocalization](https://github.com/mcamara/laravel-localization) ~ Embed Solution for URL/System Runtime localizing
- [Laravel/Socialite](https://github.com/laravel/socialite) ~ Embed Solution for Social Login
- [Zizaco/Entrust](https://github.com/Zizaco/entrust) ~ Embed Solution for applying Roles/Permissions for users
- [Dimsav/LaravelTranslatable](https://github.com/dimsav/laravel-translatable) ~ Embed Solution for Database-level localizing
- [Mews/Purifier](https://github.com/mewebstudio/Purifier) ~ Embed Solution for filtering HTML inputs
- [Maatwebsite/Excel](https://github.com/Maatwebsite/Laravel-Excel) ~ Embed Solution for exporting data to excel files
- [jenssegers/agent](https://github.com/jenssegers/agent) ~ Embed Solution for detecting browsing devices
- [barryvdh/laravel-elfinder](https://github.com/barryvdh/laravel-elfinder) ~ Embed Solution for managing files on server
- [Realtime Messaging](#realtime-messaging) ~ External Solution for chatting & notifications
- [Admin Template + Home Template](http://1drv.ms/1MpMHAA) ~ Embed Templates for Admin pages & Home/User pages
- [doctrine/dbal](https://github.com/doctrine/dbal) ~ For advanced interactions with database (esp. see [Migration](http://laravel.com/docs/5.1/migrations#modifying-columns))
- [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) ~ For advanced debugging (used by developers)

## Contributing

Steps by steps to build a module:

### Step 1. Build database-level Data Model

#### 1.1. Create/Migrate files with tables define for containing module's data

Commands:

- Create file: `php artisan make:migration %file_name% --create=%table_name%`

- Migrate new: `php artisan migrate`

- Migrate all-over-again: `php artisan migrate:refresh`

Reference: [Laravel/Database/Migrations](http://laravel.com/docs/5.1/migrations)

After created, file appears at folder `root\database\migrations`

#### 1.2. Seed some data if it's necessary

Commands

- Create file: `php artisan make:seeder %seeding_class%`

- Seed file: `php artisan db:seed --class=%seeding_class%`

Reference: [Laravel/Database/Migrations](http://laravel.com/docs/5.1/migrations)

After created, file appears at folder `root\database\seeds`

### Step 2. Build application-level Data Model

#### 2.1 Create Data Model file

Commands: `php artisan make:Model Models\%model_name%`

Reference: [Laravel/Eloquent ORM](http://laravel.com/docs/5.1/eloquent)

After created, file containing Class of Data Model appears at folder `root\app\Models`

#### 2.2 Modify Data Model class

Open model file, insert those properties into the class:

```php
// required, define the attached table
protected $table='{table_name_of_model}' // eg $table='users'
// required, define the assignable fields, without this defined, you can't save the edited fields of the model
protected $fillable={array of column names of tables that can be edited} // eg: $fillable=['name','email','password']
// optional, define the fields which include in json format of the model
protected $hidden={array of column names of tables that can be used in json format} // eg: $hidden=['name','email] => User::toJson() = {'name':'{name}','email'=>'{email}'}, the password field is not shown
```

Reference: [Laravel/Eloquent ORM](http://laravel.com/docs/5.1/eloquent)

#### 2.3 Translatate Models

For multi-language models, use Translatable model featured by [Solutions/Resources](#solutionsresources) > Dimsav/LaravelTranslatable

### Step 3. Build Routes to lead user's requests to Controllers

#### 3.1 Define Routes

Routes defined in `root\app\Http\routes.php`

Eg: `Route::post(translatedPath('blog/view/an-article'), 'Pages\BlogController@viewSingle');`

+ `post` : method for routes (`get`, `post`, ...)

+ `translatedPath('blog/view/an-article')` : the routes, can be **translatable** or not

+ `Pages\BlogController@viewSingle` : the method of controller will process the routes and return the response, format: `%folder_path%\%controller_name%@%method_name%` (see more at Step 4)

Reference: [Laravel/Routing](http://laravel.com/docs/5.1/routing)

Region to put routes is based on returning types, localization, authentication, roles & permissions.

#### 3.2 Translatable Routes

For multi-language user requests, use translatable route featured by [Solutions/Resources](#solutionsresources) > Mcamara/LaravelLocalization

It means when add translatable routes in `root\app\Http\routes.php`, you should add the translated routes in localized routes files:

`root\resources\lang\%locale%\routes.php`

### Step 4. Build Controller to process user requests directed from Routes

#### 4.1 Define controllers

Create file:

- Command: `php artisan make:controller %folder_path%\%controller_name%`

Reference [Laravel\Controllesr](http://laravel.com/docs/5.1/controllers)

After created, file appears at folder `root\app\Http\Controllers\%folder_path%`

- `%folder_path%` can be :
  + `Admin` : for admin-access functions routing controllers
  + `APIV1` : for api as services functions routing controllers
  + `Pages` : for anonymous/teacher/student/supporter/public functions routing controllers

Controller class should extends:
- `Controller` aka `BaseController`: if `%folder_path%` is APIV1
- `ViewController` if `%folder_path%` is `Admin` or `Pages`, or (esp.) having methods responsing theme templates
    - `MultipleLocaleContentController` if having methods processing the multiple locale POST-data from input forms.

Features when extending form:
- `BaseController`: inherits properties of:
    - `$locale`: locale of current request (`en`, `vi`, ...)
    - `$is_auth`: if current request belongs to an authenticated user or not
    - `$auth_user`: contains authenticated `User` of the current request if `$is_auth` is `true`
- `ViewController`: inherits properties of:
    - all properties inherited from `BaseController`
    - `$theme`: contains current theme of requests, theme can be `admin` or `lms` type.
    - `$globalViewData`: contains data shared between all templates (see more at Step 5)
- `MultipleLocaleContentController`: inherits of:
    - all properties inherited from `ViewController`
    - method `validateMultipleLocaleData`: for validating multilingual inputs (see more at Step 4.2 below)

#### 4.2 Create controllers' methods

Code Template:

```php
public function method_name(Request $request (, (optional) $param_1, (optional) $param_2, ...)) {
   // code
}
```

+ `$request` : hold all request info & params (GET, POST, ... aka REQUEST params ..)

+ `$param_n` : extra params defined in routing, (more at [here](http://laravel.com/docs/5.1/controllers#basic-controllers))

Reference [Laravel\Requests](http://laravel.com/docs/5.1/requests)

You should validate the user inputs if they exists before any processing

Reference [Laravel\Validation](http://laravel.com/docs/5.1/validation)

You should **validate the multilingual inputs** using example code:

```php
$this->validateMultipleLocaleData($request, ['title', 'slug', 'content'], [
    'title' => 'required',
    'slug' => 'required|unique:blog_article_translations,slug',
    'content' => 'required',
], $data, $successes, $fails, $old);

$error_redirect = redirect(localizedAdminURL('blog/articles/add'))
    ->withInput(array_merge([
        'categories' => $categories
    ], $old));

if (count($successes) <= 0 && count($fails) > 0) {
    return $error_redirect->withErrors($fails[0]);
}
```

- `title`, `slug`, `content`: eg. of multilingual inputs
- `categories`: eg of normal inputs
- `$data`: return value, array, contains all inputs indexed by locale
- `$successes`: return value, array, contains validated inputs indexed by locale
- `$fails`: return value, array, contains un-validated inputs indexed by locale
- `$old`: return value, array, contains inputs with formatted name `%input name%_%locale%` for serving as **old inputs**

You should filter the user inputs if they're HTML string to avoid attacks from bad guys, using [Solutions/Resources](#solutionsresources) > Mews/Purifier

#### 4.3 Make response

In a method of controllers, you should response the result of processing of the user requests (abort/redirection/json/blade template).

Reference [Laravel\Responses](http://laravel.com/docs/5.1/responses)

### Step 5. Build Template

Reference [Laravel/Blade Template](http://laravel.com/docs/5.1/blade)

If not ajax request, you should return a blade view in a method of controllers.

Templates are in folder `root\resources\views`

Templates of themes are in folder `root\resources\views\%theme_type%\%theme_name%`

- `%theme_type%` can be:
    - admin_themes
    - lms_themes

Every theme has 4 type of templates:
- `master`: contains master templates
- `pages`: contains detail templates (extending from master templates)
- `extensions`: contains extension templates if theme supports any
- `widgets`: contains widget templates if theme supports any

Other templates:
- `emails`: contains email templates (ususally email-naming folders email with localized templates inside)
- `errors`: contains error-responsing templates
- `extensions`: contains global extension templates
- `widgets`: contains global widget templates
- `file_manager`: contains global file managing module templates
- `favicons.blade.php`: template of global favicons
- `simple.blade.php`: simplest master template of a webpage

To localize the UI, use function `trans()` or `trans_choice()`, see [Laravel/Localization](http://laravel.com/docs/5.1/localization)

Data which are shared between all templates responsed by controllers extending from `ViewController`:

- `$site_locale`: locale of the current request
- `$site_version`:  application version
- `$site_name`: application name
- `$site_logo`: application logo
- `$site_keywords`: application keywords
- `$site_short_name`:  application short name
- `$site_description`: application description
- `$site_author`:  application author
- `$site_email`: application email
- `$site_domain`:  application domain
- `$site_home_url`:  application home url
- `$is_auth`: true if current request is authenticated by an user, false if not
- `$auth_user`: `User` who authenticates the request or null if no user is existed
- `$session_id`: session id

All application data is supplied by `.env` file.

## Extra Special Actions

### Google Cloud Hosting Commands

Go to **Root Folder of Site**:

`cd /var/www/antoree.com/website-v5`

MySQL connect

`mysql -u root -p antoree`

Update from Git

`sudo git pull`

Undo all changes made on server:

`sudo git checkout -- .`

Backup database data and save to Git:

```
sudo mysqldump --user="root" --password="root" --no-create-info --skip-triggers antoree > backup.sql
sudo git add backup.sql
sudo git commit -m "backup data"
sudo git push
```

All commands must be executed when in **Root Folder of Site**!!

### Realtime Messaging

Using Solution of Realtime Company

- [Realtime Co.](http://www.realtime.co/)
- [For Developer](http://framework.realtime.co/messaging/#documentation)

Account is signed up using Google Account of Antoree Dev