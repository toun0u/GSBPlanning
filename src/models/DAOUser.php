<?php
namespace models;

class DAOUser
{
  	private static $serveur='mysql:host=172.18.204.2';
  	private static $bdd='dbname=gsb';   		
  	private static $user='root' ;    		
  	private static $mdp='gsb' ;	
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
		$req = 'select * from user where mail = "'.$id.'"';
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

	public function getAllEvent()
	{
		$req = 'select even.id, lieu, description, dateDebut, dateFin, id_User, id_Type, type.libelle from even inner join type on even.id_Type = type.id';
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
	public function getEventByName($event)
	{
		$req = 'select  from even inner join type on even.id_Type=type.id where description like "%'.$event.'%"';
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
	public function addEvent($title, $start, $end)
	{
		//recupérer les valeurs envoyé
		$req = 'INSERT INTO evenement (description, dateDebut, dateFin) VALUES ('.$title.','.$start.','.$end.')';
		$res = DAOUser::$monDao->query($req);
	}

}

?>