<?php
/**
 * RegistrationController.php
 * @package Lazy
 */

namespace Lazy\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Lazy\UserBundle\Form\RegistrationFormType;
use Lazy\UserBundle\Form\UserHandler;

/**
 * RegistrationController : manages the registration
 * @package Lazy
 * @subpackage UserBundle
 * @category Controller
 */
class RegistrationController extends Controller
{
	/**
	 * First, build the form and then process it
	 */
    public function registerAction()
    {
        $form = $this->createForm(new RegistrationFormType, $this->get("wecook.usermanager")->create());
        $userHandler = new UserHandler($form,$this->get('request'),$this->getDoctrine()->getEntityManager(), $this->get('security.encoder_factory'));

        if($userHandler->process())
        {
            $user = $form->getData();
            $this->get('session')->set('wecook_user_email', $user->getUserEmail());
            return $this->forward('WeCookUserBundle:Registration:checkemail', array());
        }

        return $this->render('WeCookUserBundle:Registration:register.html.twig',array("form"=>$form->createView()));
    }

	/**
	 * Send a mail and Tell user to check his email provider 
	 */
    public function checkemailAction()
    {
        $email = $this->get('session')->get('wecook_user_email');
        $this->get('session')->remove('wecook_user_email');

        $user = $this->getDoctrine()->getEntityManager()->getRepository('WeCookBaseBundle:User')->findOneByUserEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }
        /*
        $message = \Swift_Message::newInstance()
            ->setSubject($this->get('translator')->trans("registration."))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody($this->renderView('HelloBundle:Hello:email.txt.twig', array('name' => $name)));
        */
        return $this->redirect($this->generateUrl('WeCookUserBundle_login'));
    }

    /**
     * Set the user profile from inactive to active and display confirmation
     */
    public function confirmAction()
    {
        return new Response("cool");
    }
}