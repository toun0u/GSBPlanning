<?php

namespace Sio\GsbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use models;

class DefaultController extends Controller
{
	public function indexAction()
	{
		return $this->render('SioGsbBundle:Default:index.html.twig', array('user'=>'tto'));
	}
	public function dashboardAction()
	{
		return $this->render('SioGsbBundle:Default:dashboard.html.twig');
	}

	public function connexionAction(Request $request)
	{
		dump($request);
		if($request->request->has('valider'))
		{
			$msg = "";
			$mail = $request->get('email');
			$mdp = $request->get('password');
			$dao = models\DAOUser::getDaoUser();
			$res = $dao->getUserById($mail);
			if(count($res == 0))
			{
				$msg = "identifiant non valide";
			}else{
				if ($mdp == $res['mdp'])
				{
					$msg = "Connexion réussie";
				}else{
					$msg = "Mot de passe incorrect";
				}
			}

		}
		return $this->render('SioGsbBundle:Default:index.html.twig');
	}
}
