# An auth driver for Laravel 4 and Sentry 2

This is a provider for adding a sentry driver to your auth system for laravel 4.  
[![endorse](https://api.coderwall.com/bretterer/endorsecount.png)](https://coderwall.com/bretterer)



## Installation 

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `lamarus/sentry-driver`.

  "require": {
    "lamarus/sentry-driver": "dev-master"
  },
  "minimum-stability" : "dev"

Next, update Composer from the Terminal:

    composer update



Once you have added your configuration, add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Lamarus\SentryDriver\SentryDriverServiceProvider'

The final step is to change your auth driver.  Open `app/config/auth.php`, and change the driver to `sentry`



## Usage

This driver replacement has been created to make it easy to replace the current auth.  All the commands are the same and are used just like the current way.

### Examples

    Route::get('login/once', function() {
       if(Auth::once(['email'=>'test@gmail.com', 'password'=>'test'])) {
        return Redirect::to('check');
      } else {
        return Redirect::to('error');
      }
    });

    Route::get('login/remember', function() {
     
       if(Auth::attempt(['email'=>'test@gmail.com', 'password'=>'test'], true)) {
        return Redirect::to('check');
      } else {
        return Redirect::to('error');
      }
    });

    Route::get('login/{id}', function($id) {
      Auth::loginUsingId($id);
    });

    Route::get('login', function() {
      if(Auth::attempt(['email'=>'test@gmail.com', 'password'=>'test'])) {
        return Redirect::to('check');
      } else {
        return Redirect::to('error');
      }
    });

    Route::get('logout', function() {
      var_dump(Auth::logout());
    });

    Route::get('check', function() {

      if(Auth::check()) {
        print Auth::user()->email . '<br/>';
      }

      var_dump(Auth::check());
    });

    Route::get('error', function() {
      print_r(Session::get('SentryException'));
    });