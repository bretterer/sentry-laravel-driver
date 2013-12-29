<?php namespace Lamarus\SentryDriver\Providers;

use Illuminate\Auth\UserProviderInterface;
use Illuminate\Auth\GenericUser;

class SentryUserProvider implements UserProviderInterface {

    public function retrieveById($identifier)
    {

      try
      {
          $user = \Sentry::findUserById($identifier);
          return new GenericUser(['email'=>$user->email,'password'=>$user->password,'id'=>$user->id]);
      }
      catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
         \Session::flash('SentryException', 'User was not found.');
         return new GenericUser(['email'=>null,'password'=>null,'id'=>null]);
      }
      
      
          
    }
 
    public function retrieveByCredentials(array $credentials)
    {
      try
      {
          $user = \Sentry::findUserByLogin($credentials['email']);
      }
      catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
        \Session::flash('SentryException', 'User was not found.');
        return false;
      }

      if ( ! is_null($user))
      {
        return new GenericUser(['email'=>$user->email,'password'=>$user->password,'id'=>$user->id]);
      }
    }
 
    public function validateCredentials(\Illuminate\Auth\UserInterface $user, array $credentials)
    {
      try {
        \Sentry::authenticate($credentials, false);
        return true;
      }
      catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
      {
        \Session::flash('SentryException', 'Login field is required.');
        return false;
      }
      catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
      {
        \Session::flash('SentryException', 'Password field is required.');
          return false;
      }
      catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
      {
        \Session::flash('SentryException', 'Wrong password, try again.');
          return false;
      }
      catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
        \Session::flash('SentryException', 'User was not found.');
          return false;
      }
      catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
      {
        \Session::flash('SentryException', 'User is not activated.');
          return false;
      }

      // The following is only required if throttle is enabled
      catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
      {
        \Session::flash('SentryException', 'User is suspended.');
          return false;
      }
      catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
      {
        \Session::flash('SentryException', 'User is banned.');
          return false;
      }

    }

}