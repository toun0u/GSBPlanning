<?php
namespace models;

public class DAOUser
{
  	private static $serveur='mysql:host=172.18.204.2';
  	private static $bdd='dbname=gsb';   		
  	private static $user='root' ;    		
  	private static $mdp='gsb' ;	
	private static $monDao;

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
		if(DAOUser::$monDao == null)
		{
			DAOUser::$monDao = new DAOUser();
		}
		return DAOUser::$monDao;
	}

	public function getUserById($id)
	{
		$req = 'select * from user where mail = '.$id;
		$res = DAOUser::$monDao->query($req);
		$lesLignes = $res -> fetchAll();
		return $lesLignes;
	}
}

?>