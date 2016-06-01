<?php
namespace models;

class DAOUser
{
  	private static $serveur='mysql:host=127.0.0.1';
  	private static $bdd='dbname=gsb';   		
  	private static $user='root' ;    		
  	private static $mdp='' ;
	private static $monDao;
	private static $monDaoGsb = null;

	private function __construct()
	{
		DAOUser::$monDao = new \PDO(DAOUser::$serveur.';'.DAOUser::$bdd, DAOUser::$user, DAOUser::$mdp);
		DAOUser::$monDao->query('SET CHARACTER SET utf8');
	}
	public function _destruct()
	{
		DAOUser::$monDao = null;
	}

	public static function getDaoUser()
	{
		if(DAOUser::$monDaoGsb == null)
		{
			DAOUser::$monDaoGsb = new DAOUser();
		}
		return DAOUser::$monDaoGsb;
	}

	public function getUserById($id)
	{
		$req = 'select * from user where id = "'.$id.'"';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}

	public function getUserByMail($mail)
	{
		$req = 'select * from user where mail = "'.$mail.'"';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}

	public function getUserByName($name)
	{
		$req = "select * from user where Nom = '".$name."'";
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}

	public function getUserByFirstName($fname)
	{
		$req = "select * from user where Prenom = '".$fname."'";
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}

	public function getUserByService($idService)
	{
		$req = "select * from user where id_service = ".$idService;
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}
	public function getServiceResponsable($idService)
	{
		$req = 'select * from user where id_service ='.$idService.' and id_service != 0';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}
	public function getMail()
	{
		$req ="select mail from user";
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}
	public function getEventByDate()
	{
		$req = "SELECT dateDebut from even where dateDebut between cast(now() as date) and cast(now() +interval 3 day as date)";
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}

	public function getAllEvent()
	{
		$req = 'select even.id, lieu, description, dateDebut, dateFin, id_User, id_Type, heureDebut, heureFin, type.titre from even inner join type on even.id_Type = type.id';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
	public function getEventByName($event)
	{
		$req = 'select * from even inner join type on even.id_Type=type.id where description like "%'.$event.'%"';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
	public function getEvenByIdUser($id)
	{
		$req = "select * from even inner join user on even.id_User = user.id inner join type on even.id_Type=type.id where even.id=".$id;
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
	public function getAllType()
	{
		$req = 'select * from type';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function getAllService()
	{
		$req = 'select service.id, libelle, Nom, Prenom from service inner join user on service.id_User = user.id';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function suppPart($id)
	{
		$req = "delete from participer where id_Event=".$id;
		$res = DAOUser::$monDao->query($req);
	}
	public function suppEvent($id)
	{
		$req = "delete from even where id=".$id;
		$res = DAOUser::$monDao->query($req);
	}

	public function addEvent($lieu, $description, $libelle, $dateDebut, $dateFin, $heureDebut, $heureFin, $idTitre, $idUser)
	{
		$req = "insert into even (lieu, description, dateDebut, dateFin, id_User, id_type, heureDebut, heureFin, Libelle) values ('".$lieu."', '".$description."', '".$dateDebut."', '".$dateFin."', ".$idUser.", ".$idTitre.", '".$heureDebut."', '".$heureFin."', '".$libelle."')";
		$res = DAOUser::$monDao->query($req);

	}
	public function updateEvent($lieu, $description, $dateDebut, $dateFin, $heureDebut, $heureFin, $idTitre, $id)
	{
		$req = "update even set lieu = '".$lieu."', description = '".$description."', dateDebut = '".$dateDebut."', dateFin = '".$dateFin."',id_type = ".$idTitre.", heureDebut = '".$heureDebut."', heureFin = '".$heureFin."' where id =".$id;
		$res = DAOUser::$monDao->query($req);
	}
	public function mailChange($mail, $id)
	{
		$req = "update user set mail='".$mail."' where id=".$id;
		$res = DAOUser::$monDao->query($req);
	}
	public function mdpChange($mdp, $id)
	{
		$req = "update user set mdp='".$mdp."' where id=".$id;
		$res = DAOUser::$monDao->query($req);
	}

}

?>