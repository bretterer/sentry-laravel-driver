<?php namespace Lamarus\SentryDriver;

use Illuminate\Auth\UserInterface;

class SentryUser implements UserInterface {

	protected $user;

	public function __construct($user) {
		$this->user = $user;
	}

	
	public function getAuthIdentifier() {
		// print '<pre>';
		// dd(json_encode($this->user['id']));
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {

	}
}