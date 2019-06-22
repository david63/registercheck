<?php
/**
*
* @package Registration Check Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registercheck\controller;

/**
* @ignore
*/
use Symfony\Component\HttpFoundation\Response;

use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\config\config;

/**
* Main controller
*/
class main_controller
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var string phpBB tables */
	protected $tables;

	/**
	* Constructor for main_controller
	*
	* @param \phpbb\db\driver\driver_interface	$db			Database object
	* @param \phpbb\request\request				$request	Request object
	* @param \phpbb\config\config				$config		Config object
	* @param array								$tables		phpBB db tables
	*
	* @return \david63\registercheck\controller\main_controller
	* @access public
	*/
	public function __construct(driver_interface $db, request $request, config $config, $tables)
	{
		$this->db 		= $db;
		$this->request	= $request;
		$this->config	= $config;
		$this->tables	= $tables;
	}

	/**
	* Check if username (username_clean) is available.
	*
	* @param string username
	*
	* @return user_count
	*/
	public function check_name($username)
	{
		// We will use username_clean rather than username as it should be more accurate
		// although it may provide some false positives.
		$username 		= $this->request->variable('username', '');
		$username_clean	= utf8_clean_string($username);

		$sql = 'SELECT COUNT(username_clean) AS total_users
			FROM ' . $this->tables['users'] . '
				WHERE username_clean= "' . $this->db->sql_escape($username_clean) . '"';

		$result 	= $this->db->sql_query($sql);
		$user_count	= (int) $this->db->sql_fetchfield('total_users');

		$this->db->sql_freeresult($result);

		return new Response ($user_count);
	}

	/**
	* Check if email address is available.
	*
	* @param string email
	*
	* @return email_count
	*/
	public function check_email($email)
	{
		if (!$this->config['allow_emailreuse'])
		{
			$user_email = strtolower($this->request->variable('email', ''));

			$sql = 'SELECT COUNT(user_email) AS total_email
				FROM ' . $this->tables['users'] . '
					WHERE user_email= "' . $this->db->sql_escape($user_email) . '"';

			$result 		= $this->db->sql_query($sql);
			$email_count	= (int) $this->db->sql_fetchfield('total_email');

			$this->db->sql_freeresult($result);

			return new Response ($email_count);
		}
	}

	/**
	* Check if the passwords match.
	*
	* @param string email
	*
	* @return passwords_match
	*/
	public function check_passwords($passwords)
	{
		$new_password 		= $this->request->variable('newPassword', '', false, \phpbb\request\request_interface::POST);
		$password_confirm 	= $this->request->variable('passwordConfirm', '', false, \phpbb\request\request_interface::POST);

		// 'true' & 'false' have to be returned as strings
		$passwords_match = ($new_password === $password_confirm) ? 'true' : 'false';

		return new Response ($passwords_match);
	}
}
