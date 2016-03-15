<?php

namespace Sio\GsbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use models;
use Symfony\Component\HTTPFoundation\Request;
use Symfony\Component\HTTPFoundation\Session\Session;

class DefaultController extends Controller
{
	public function indexAction()
	{
		return $this->render('SioGsbBundle:Default:index.html.twig', array('user'=>' '));
	}
	public function dashboardAction()
	{
		return $this->render('SioGsbBundle:Default:dashboard.html.twig');
	}

	public function connexionAction(Request $request)
	{
		if($request->request->has('valider'))
		{
			$msg = "";
			$mail = $request->get('email');
			$mdp = $request->get('password');
			$dao = models\DAOUser::getDaoUser();
			$res = $dao->getUserById($mail);
			//dump($res[0]['mdp']);
			if(count($res)==0)
			{
				$msg = "identifiant non valide";
				return $this->render('SioGsbBundle:Default:index.html.twig', array('user' =>$msg));
			}else{
				if ($mdp == $res[0]['mdp'])
				{
					$_SESSION['user'] = $res[0]['Nom'].' '.$res[0]['Prenom'];
					$msg = $_SESSION['user'];

				}else{
					$msg = "Authentification incorrect";
					return $this->render('SioGsbBundle:Default:index.html.twig', array('user' =>$msg));
				}
			}

		}
		return $this->render('SioGsbBundle:Default:dashboard.html.twig', array('user' =>$msg));
	}
}
