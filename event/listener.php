<?php
/**
*
* @package Registration Check Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registercheck\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use phpbb\language\language;
use phpbb\template\template;
use phpbb\controller\helper;
use david63\registercheck\core\functions;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \david63\registercheck\core\functions */
	protected $functions;

	/**
	* Constructor for listener
	*
	* @param \phpbb\language\language				$language	Language object
	* @param \phpbb\template\template				$template	Template object
	* @param \phpbb\controller\helper				$helper		Helper object
	* @param \david63\registercheck\core\functions	$functions	Functions for the extension
	*
	* @return \david63\registercheck\event\listener
	* @access public
	*/
	public function __construct(language $language, template $template, helper $helper, functions $functions)
	{
		$this->language 	= $language;
		$this->template		= $template;
		$this->helper		= $helper;
		$this->functions	= $functions;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_register_data_before' => 'register',
		);
	}

	/**
	* Load the template variables
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function register($event)
	{
		// Add the language file
		$this->language->add_lang('registercheck', $this->functions->get_ext_namespace());

		$this->template->assign_vars(array(
			'UA_EMAIL_CHECK'	=> $this->helper->route('david63_registercheck_check_email', array('email' => 0)),
			'UA_NAME_CHECK' 	=> $this->helper->route('david63_registercheck_check_name', array('username' => 0)),
			'UA_PASSWORD_CHECK' => $this->helper->route('david63_registercheck_check_passwords', array('passwords' => 0)),
		));
	}
}
