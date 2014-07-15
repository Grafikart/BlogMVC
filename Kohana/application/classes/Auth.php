<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * A custom Auth using the database
 */
// J'ai utilisé la classe du module Auth que j'ai un peu modifiée
class Auth{
	
	// Auth instances
	protected static $_instance;
	
	// The User
	protected $user;
	
	protected static $session_key  = 'auth_user';
	protected static $lifetime     = 1209600;
	
	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance()
	{
		if ( ! isset(Auth::$_instance))
		{
			// Create a new session instance
			Auth::$_instance = new Auth();
		}
	
		return Auth::$_instance;
	}
	

	protected $_session;
	
	/**
	 * Loads Session and configuration options.
	 *
	 * @param   array  $config  Config Options
	 * @return  void
	 */
	public function __construct()
	{
	
		$this->_session = Session::instance();
	}
	

	/**
	 * Attempt to log in a user by using an ORM object and plain-text password.
	 *
	 * @param   string   $username  Username to log in
	 * @param   string   $password  Password to check against
	 * @param   boolean  $remember  Enable autologin
	 * @return  boolean
	 */
	public function login($username, $password, $remember = FALSE)
	{
		if (empty($password))
			return FALSE;
	
		return $this->_login($username, $password, $remember);
	}
	
	/**
	 * Logs a user in.
	 *
	 * @param   string   $username  Username
	 * @param   string   $password  Password
	 * @param   boolean  $remember  Enable autologin (not supported)
	 * @return  boolean
	 */
	protected function _login($username, $password, $remember)
	{
		if (is_string($password))
		{
			// Create a hashed password
			$password = $this->hash($password);
		}
	
		$user = new Model_User();
		$user->where('username', '=', $username)->find();
		if ($user->loaded() AND $user->password === $password)
		{
			// Complete the login
			return $this->complete_login($user);
		}
	
		// Login failed
		return FALSE;
	}
	
	/**
	 * Forces a user to be logged in, without specifying a password.
	 *
	 * @param   mixed    $username  Username
	 * @return  boolean
	 */
	public function force_login($user)
	{
		if(is_string($user)){
			$user = (new Model_User())->where('username', '=', $user)->find();
		}
		
		return $this->complete_login($user);
	}
	
	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   $username  Username
	 * @return  string
	 */
	public function password($username)
	{
		return (new Model_User())->where('username', '=', $username)->find()->password;
	}
	
	/**
	 * Compare password with original (plain text). Works for current (logged in) user
	 *
	 * @param   string   $password  Password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		$user = $this->get_user();
	
		if (!$user->loaded())
		{
			return FALSE;
		}
	
		return ($password === $user->password);
	}
	
	/**
	 * Gets the currently logged in user from the session.
	 * Returns NULL if no user is currently logged in.
	 *
	 * @param   mixed  $default  Default value to return if the user is currently not logged in.
	 * @return  Model_User
	 */
	public function get_user($default = NULL)
	{
		if(! isset($this->user)){
			$serialized = $this->_session->get(Auth::$session_key, NULL);
			if($serialized == NULL)return $default;
			$this->user = unserialize($serialized);
		}
		return $this->user;
	}
	
	/**
	 * @param   Model_User  $user  User value to return if the user is currently not logged in.
	 * @return  boolean
	 */
	protected function complete_login(Model_User $user)
	{
		// Regenerate session_id
		$this->_session->regenerate();
		
		$this->user = &$user;
	
		// Store username in session
		$this->_session->set(Auth::$session_key, serialize($user));
	
		return TRUE;
	}
	
	/**
	 * Check if there is an active session. Optionally allows checking for a
	 * specific role.
	 *
	 * @param   string  $role  role name
	 * @return  bool
	 */
	public function logged_in($role = NULL)
	{
		if($role == NULL){
			return ($this->get_user() !== NULL);
		} else return ($this->get_user() !== NULL) && $this->get_user()->type->name = $role;
	}
	
	/**
	 * Creates a hashed hmac password from a plaintext password. This
	 * method is deprecated, [Auth::hash] should be used instead.
	 *
	 * @deprecated
	 * @param  string  $password Plaintext password
	 */
	public function hash_password($password)
	{
		return $this->hash($password);
	}
	
	/**
	 * Perform a hmac hash, using the configured method.
	 *
	 * @param   string  $str  string to hash
	 * @return  string
	 */
	public function hash($str)
	{
		//if ( ! $this->_config['hash_key'])
			//throw new Kohana_Exception('A valid hash key must be set in your auth config.');
	
		return sha1($str);
	}
	

	/**
	 * Log out a user by removing the related session variables.
	 *
	 * @param   boolean  $destroy     Completely destroy the session
	 * @param   boolean  $logout_all  Remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		if ($destroy === TRUE)
		{
			// Destroy the session completely
			$this->_session->destroy();
		}
		else
		{
			// Remove the user from the session
			$this->_session->delete(Auth::$session_key);
	
			// Regenerate session_id
			$this->_session->regenerate();
		}
	
		// Double check
		return ! $this->logged_in();
	}
	
	
}