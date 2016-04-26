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
	public function detailEventAction()
	{
		//$dao = models\DAOUser::getDaoUser();
		//$res = $dao->getUserById();
		return $this->render('SioGsbBundle:Default:detailEvent.html.twig');
	}
	public function calendaradminAction()
	{

		$dao = models\DAOUser::getDaoUser();
		$res = $dao->getAllEvent();
		$json = '';
		$tojson=[];
		for($i=0;$i<count($res);$i++)
		{
			$tab=[];
			for($j=0;$j<10;$j++)
			{
				$tab[]=$res[$i][$j];
			}
			$tojson[$i]=array('id'=>$tab[0], 'lieu'=>$tab[1], 'description'=>$tab[2], 'dateDebut'=>$tab[3], 'dateFin'=>$tab[4], 'id_User'=>$tab[5], 'id_Type'=>$tab[6], 'heureDebut'=>$tab[7], 'heureFin'=>$tab[8],'Libelle'=>$tab[9]);

		}

		$json = $tojson;//json_encode($tojson,JSON_UNESCAPED_UNICODE);
		dump($json);

		return $this->render('SioGsbBundle:Default:calendaradmin.html.twig', array('event' => $json));
	}

	public function connexionAction(Request $request)
	{
		$session = new Session();

		if($request->request->has('submit_formulaire_identification'))
        {
			$msg = "";
			$mail = $request->get('email_formulaire_identification');
			$mdp = $request->get('password_formulaire_identification');
			$dao = models\DAOUser::getDaoUser();
			$res = $dao->getUserByMail($mail);

			if(count($res)==0)
			{
				$msg = "identifiant non valide";
				return $this->render('SioGsbBundle:Default:index.html.twig', array('user' =>$msg));
			}else{
				if ($mdp == $res[0]['mdp'])
				{
					$session->set('nom',$res[0]['Nom'].' '.$res[0]['Prenom']);
					$msg = $session->get('nom');
				}else{
					$msg = "Authentification incorrect";
					return $this->render('SioGsbBundle:Default:index.html.twig', array('user' =>$msg));
				}
			}

		}

		return $this->render('SioGsbBundle:Default:dashboard.html.twig', array('user' =>$msg));
	}
}
