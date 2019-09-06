# SPINEN's Laravel QuickBooks Client

[![Latest Stable Version](https://poser.pugx.org/spinen/laravel-quickbooks-client/v/stable)](https://packagist.org/packages/spinen/laravel-quickbooks-client)
[![Latest Unstable Version](https://poser.pugx.org/spinen/laravel-quickbooks-client/v/unstable)](https://packagist.org/packages/spinen/laravel-quickbooks-client)
[![Total Downloads](https://poser.pugx.org/spinen/laravel-quickbooks-client/downloads)](https://packagist.org/packages/spinen/laravel-quickbooks-client)
[![License](https://poser.pugx.org/spinen/laravel-quickbooks-client/license)](https://packagist.org/packages/spinen/laravel-quickbooks-client)

PHP client wrapping the [QuickBooks PHP SDK](https://github.com/intuit/QuickBooks-V3-PHP-SDK).

We solely use [Laravel](https://www.laravel.com) for our applications, so this package is written with Laravel in mind. If there is a request from the community to split this package into 2 parts to allow it to be used outside of Laravel, then we will consider doing that work.

## Build Status

| Branch | Status | Coverage | Code Quality |
| ------ | :----: | :------: | :----------: |
| Develop | [![Build Status](https://travis-ci.org/spinen/laravel-quickbooks-client.svg?branch=develop)](https://travis-ci.org/spinen/laravel-quickbooks-client) | [![Code Coverage](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/?branch=develop) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/?branch=develop) |
| Master | [![Build Status](https://travis-ci.org/spinen/laravel-quickbooks-client.svg?branch=master)](https://travis-ci.org/spinen/laravel-quickbooks-client) | [![Code Coverage](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/?branch=develop) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spinen/laravel-quickbooks-client/?branch=master) |

## Installation

Install QuickBooks PHP Client:

```bash
$ composer require Responsilicious/laravel-quickbooks-client
```

The package uses the [auto registration feature](https://laravel.com/docs/5.8/packages#package-discovery) of Laravel 5.

## Configuration

1. You will need a ```quickBooksToken``` relationship on your ```User``` model.  There is a trait named ```Responsilicious\QuickBooks\Laravel\HasQuickBooksToken```, which you can include on your ```User``` model, which will setup the relationship.  **NOTE: If your ```User``` model is not ```App/User```, then you will need to configure the path in the ```configs/quickbooks.php``` as documented below.**

2. Add the appropriate values to your ```.env```

    #### Minimal Keys
    ```bash
    QUICKBOOKS_CLIENT_ID=<client id given by QuickBooks>
    QUICKBOOKS_CLIENT_SECRET=<client secret>
    ```

    #### Optional Keys
    ```bash
    QUICKBOOKS_API_URL=<Development|Production> # Defaults to App's env value
    QUICKBOOKS_DEBUG=<true|false>               # Defaults to App's debug value
    ```

3. _[Optional]_ Publish configs & views

    #### Config
    A configuration file named ```quickbooks.php``` can be published to ```config/``` by running...
    
    ```bash
    php artisan vendor:publish --tag=quickbooks-config
    ```
    
    #### Views
    View files can be published by running...
    
    ```bash
    php artisan vendor:publish --tag=quickbooks-views
    ```

## Usage

Here is an example of getting the company information from QuickBooks:

```php
php artisan tinker
Psy Shell v0.8.17 (PHP 7.1.14 — cli) by Justin Hileman
>>> Auth::logInUsingId(1)
=> App\User {#1668
     id: 1,
     // Other keys removed for example
   }
>>> $quickbooks = app('Responsilicious\QuickBooks\Client') // or app('QuickBooks')
=> Responsilicious\QuickBooks\Client {#1613}
>>> $quickbooks->getDataService()->getCompanyInfo();
=> QuickBooksOnline\API\Data\IPPCompanyInfo {#1673
     +CompanyName: "Sandbox Company_US_1",
     +LegalName: "Sandbox Company_US_1",
     // Other properties removed for example
   }
>>>
```

You can call any of the resources as documented [in the SDK](https://intuit.github.io/QuickBooks-V3-PHP-SDK/quickstart.html).

## Middleware

If you have routes that will be dependent on the user's account having a usable QuickBooks OAuth token, there is an included middleware ```Responsilicious\QuickBooks\Laravel\Filter``` that gets registered as ```quickbooks``` that will ensure the account is linked and redirect them to the `connect` route if needed.

Here is an example route definition:

```php
Route::view('some/route/needing/quickbooks/token/before/using', 'some.view')
     ->middleware('quickbooks');
```
