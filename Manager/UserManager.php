<?php

/**
* UserManager.php 
* @package WeCook
*/

namespace Lazy\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use WeCook\BaseBundle\Manager\BaseManager;
use Lazy\UserBundle\Entity\User;

/**
* Manager for Entity User
* @package Lazy
* @subpackage UserBundle
* @category Manager
* @author Thomas Quiroga
*/
class UserManager extends BaseManager
{
	/**
	* Entity Manager
	* @var $em
	* @access protected
	*/
	protected $em;

	/**
	* Constructor
	* @param EntityManager $em
	*/
	function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
}