<?php
/**
 * SecurityController.php
 * @package WeCook
 */

namespace WeCook\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * SecurityController
 * @package WeCook
 * @subpackage UserBundle
 * @category Controller
 */
class SecurityController extends Controller
{
    /**
     * Build and display Login form 
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('WeCookUserBundle:Security:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * Check credentials and redirect
     */
    public function checkAction()
    {
        $locale = $this->get('session')->getLocale();
        return $this->render('WeCookUserBundle:Security:login.html.twig');
    }

    /**
     * Logout the user and redirect 
     */
    public function logoutAction()
    {   
        return $this->render('WeCookUserBundle:Security:login.html.twig');
    }
}