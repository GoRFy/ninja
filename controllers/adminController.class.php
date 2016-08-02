<?php

require_once "models/User.class.php";


class adminController
{
    public function indexAction($args)
    {
        $view = new view;
        if(User::isConnected()){
            if(User::isAdmin()){
                $view->setView("admin/ui-collection.tpl");
            }else{
                header("Location:".WEBROOT);
            }
        }else{
            header("location: ".WEBROOT."user/login");
        }

    }

    public function globalAction($args)
    {
        $view = new view;
        if(User::isConnected()){
            if(User::isAdmin()){
                $view->setView('admin/global.tpl');

                $users = User::FindAll();
                $totalUser = count($users);
                $userParPage=10;
                $nombreDePagesUser=ceil($totalUser/$userParPage);

                if(isset($_GET['page'])){
                     $pageActuelleUser=intval($_GET['page']);
                     if($pageActuelleUser>$nombreDePagesUser)
                     {
                          $pageActuelleUser=$nombreDePagesUser;
                     }
                }else{
                     $pageActuelleUser=1;
                }
                $premiereEntreeUser=($pageActuelleUser-1)*$userParPage;
                // La requête sql pour récupérer les messages de la page actuelle.
                //$retour_messagesUser= User::findAll([$premiereEntreeUser,$userParPage],'username','ASC');
                $retour_messagesUser = User::findAll([$premiereEntreeUser,$userParPage],true,'username');
                $teams = Team::FindAll();
                $totalTeam = count($users);
                $teamParPage=10;
                $nombreDePagesTeam=ceil($totalTeam/$teamParPage);

                if(isset($_GET['page'])){
                     $pageActuelleTeam=intval($_GET['page']);
                     if($pageActuelleTeam>$nombreDePagesTeam)
                     {
                          $pageActuelleTeam=$nombreDePagesTeam;
                     }
                }else{
                     $pageActuelleTeam=1;
                }
                $premiereEntreeTeam=($pageActuelleTeam-1)*$teamParPage;
                // La requête sql pour récupérer les messages de la page actuelle.
                //$retour_messagesTeam= Team::findAll([$premiereEntreeTeam,$teamParPage],'teamName','ASC');
                $retour_messagesTeam = Team::findAll([$premiereEntreeUser,$userParPage],true,'teamName');

                $view->assign('pageActuelleTeam', $pageActuelleTeam);
                $view->assign('nombreDePagesTeam',$nombreDePagesTeam);
                $view->assign("teams", $retour_messagesTeam);

                $view->assign('pageActuelleUser', $pageActuelleUser);
                $view->assign('nombreDePagesUser',$nombreDePagesUser);
                $view->assign("users", $retour_messagesUser);

            }else{
                header("Location:".WEBROOT);
            }
        }else{
            header("location: ".WEBROOT."user/login");
        }
    }

    # Create database
    public function createdbAction($args) {
       $pdo = new PDO("mysql:host=".DBHOST,DBUSER,DBPWD);

       try {
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `".DBNAME."`;");
       }catch(Execption $e) {
            die("Error while creating database : ".$e->getMessage());
       }

       header("location: ".WEBROOT."admin/initdb");
    }

    # Create tables
    public function initdbAction($args) {

        $pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME,DBUSER,DBPWD);

        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS users(
                    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    email VARCHAR(50),
                    conf_email VARCHAR(50),
                    password VARCHAR(100),
                    username VARCHAR(50),
                    first_name VARCHAR(50),
                    last_name VARCHAR(50),
                    phone_number int(20),
                    city VARCHAR(50),
                    access_token VAARCHAR(50),
                    favorite_sports LONGTEXT
                );"
            );
        } catch (Execption $e) {
            die("Error while creating table user : ".$e->getMessage());
        }

        $admin = new User();
        $admin->setUsername("Admin");
        $admin->setEmail("admin@admin.admin");
        $admin->save();

        echo DBNAME;

    }


    # Delete db
    # Use with caution
    public function deletedbAction($args) {
        $pdo = new PDO("mysql:host=".DBHOST,DBUSER,DBPWD);
    }


    public function showUiKitAction() {
        $view = new View();
        $view->setView("admin/ui-collection.tpl");
    }
}
