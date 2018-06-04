<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction(Request $request)
    {
        $user = new User();
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
            '_username' => $lastUsername,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository(User::class)->findBy(array(
                'email' => $form->getNormData()['_username'],
                'password' => $form->getNormData()['_password']
            ));

            return $this->render('login/index.html.twig', array(
                'user' => $user,
                'last_username' => $lastUsername,
                'error' => $error,
                'form' => $form->createView(),
            ));
        }

        return $this->render('login/index.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form->createView(),
        ));
    }
}
