<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $user = new User();

        // Create form
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('welcome@mail.co')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/hello.html.twig',
                        array('user' => $user)
                    ),
                    'text/html'
                );

            $mailer->send($message);

            return $this->render('bloc/register_done.html.twig', array(
                'mail' => $user->getEmail(),
            ));
        }

        // Render form
        return $this->render('user/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
