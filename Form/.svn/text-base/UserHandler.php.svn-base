<?php
/**
 * UserHandler.php
 * @package WeCook
 */

namespace WeCook\UserBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use WeCook\BaseBundle\Entity\User;

/**
 * UserHandler 
 * @package WeCook
 * @subpackage UserBundle
 * @category FormHandler
 * @author Thomas Quiroga
 */
class UserHandler
{
	/**
	 * Form to process
	 */
    protected $form;

    /**
     * Current request
     */
    protected $request;

    /**
     * Entity Manager
     */
    protected $em;

    /**
     * Password Encoder
     */
    protected $factory;
    /**
     * Constructor
     */
    public function __construct(Form $form, Request $request, EntityManager $em, $factory = null)
    {
    	$this->form = $form;
    	$this->request = $request;
    	$this->em = $em;
        $this->factory = $factory; 
    }

    /**
     * Process form values
     */
    public function process()
    {
    	if($this->request->getMethod() == 'POST')
    	{
    		$this->form->bindRequest($this->request);
    		if($this->form->isValid())
    		{
    			$this->onSuccess($this->form->getData());
    			return true;
    		}
    		return false;
    	}
    }

    /**
     * Actions to do if validation is a Success
     */
    public function onSuccess(User $user)
    {
        //Crypt the password 
        if($this->factory != null)
        {
            $encoder = $this->factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getUserPassword(), $user->getUserSalt());
            $user->setUserPassword($password);
        }

        //Persist and flush the entity
    	$this->em->persist($user);
    	$this->em->flush();
    }
}

