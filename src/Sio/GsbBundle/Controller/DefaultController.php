<?php

namespace Sio\GsbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use models;
use Symfony\Component\HTTPFoundation\Request;

class DefaultController extends Controller
{
	public function indexAction()
	{

		return $this->render('SioGsbBundle:Default:index.html.twig', array('msg'=>'trkill'));
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
			dump($res[0]['mdp']);
			if(count($res)==0)
			{
				$msg = "identifiant non valide";
			}else{
				if ($mdp == $res[0]['mdp'])
				{
					$msg = "Connexion réussie";
				}else{
					$msg = "Mot de passe incorrect";
				}
			}

		}
		return $this->render('SioGsbBundle:Default:index.html.twig', array('msg'=>$msg));
	}
}
