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
	public function toaddEventAction(Request $request)
	{

		$lieu = $request->get('lieu');
		$description = $request->get('description');
		$libelle = $request->get('libelle');
		$dateDebut = $request->get('dateDebut');
		$dateFin = $request->get('dateFin');
		$heureDebut = $request->get('heureDebut');
		$heureFin = $request->get('heureFin');
		$idTitre = $request->get('titre');
		$idUser = $request->get('user');

		$dao = models\DAOUser::getDaoUser();
		$res = $dao->addEvent($lieu, $description, $libelle, $dateDebut, $dateFin, $heureDebut, $heureFin, $idTitre, $idUser);
		dump($res);
		$response = $this->forward('SioGsbBundle:Default:calendaradmin');

		return $response;
	}
	public function detailEventAction($valeur)
	{
		$session = new Session();

		$dao = models\DAOUser::getDaoUser();
		$res = $dao->getEvenByIdUser($valeur);

		$res1 = $dao->getAllType();
		$session->set('id', $res[0]['id']);
		$session->set('lieu',$res[0]['lieu']);
		$session->set('description',$res[0]['description']);
		$session->set('dateDebut',$res[0]['dateDebut']);
		$session->set('dateFin',$res[0]['dateFin']);
		$session->set('heureDebut',$res[0]['heureDebut']);
		$session->set('heureFin',$res[0]['heureFin']);
		$session->set('titre',$res[0]['titre']);
		$session->set('alltitre', $res1[0]['titre']);
		$session->set('allidtitre',$res1[0]['id']);

        $lesTypes = $dao->getAllType();

		return $this->render('SioGsbBundle:Default:detailEvent.html.twig', array('lesTypes' => $lesTypes));
	}

	public function updateEventAction(Request $request)
	{
		$id = $request->get('id');
		$lieu = $request->get('lieu');
		$description = $request->get('description');
		$dateDebut = $request->get('dateDebut');
		$dateFin = $request->get('dateFin');
		$heureDebut = $request->get('heureDebut');
		$heureFin = $request->get('heureFin');
		$idTitre = $request->get('titre');
		$dao = models\DAOUser::getDaoUser();
		$res = $dao->updateEvent($lieu, $description, $dateDebut, $dateFin, $heureDebut, $heureFin, $idTitre, $id);

		$response = $this->forward('SioGsbBundle:Default:calendaradmin');

		return $response;
	}
	public function suppEventAction(Request $request)
	{
		$id = $request->get('id');
		$dao = models\DAOUser::getDaoUser();
		$res1 = $dao->suppPart($id);

		$res = $dao->suppEvent($id);

		$response = $this->forward('SioGsbBundle:Default:calendaradmin');

		return $response;
	}

	public function addEventAction()
	{
		return $this->render('SioGsbBundle:Default:addEvent.html.twig');
	}

	public function calendaradminAction()
	{
		$session = new Session();
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
			$session->set('idEven', $tab[0]);
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

					$session->set('nom',$res[0]['Prenom'].' '.$res[0]['Nom']);
					$session->set('user', $res[0]['id']);

				}else{
					$msg = "Authentification incorrect";
					return $this->render('SioGsbBundle:Default:index.html.twig', array('user' =>$msg));
				}
			}

		}

		return $this->render('SioGsbBundle:Default:dashboard.html.twig');
	}
}
