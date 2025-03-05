<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/header.php';

$page = isset($_GET ['page']) ? $_GET['page'] : 'accueil';

switch ($page) {

	case 'compte' :
            include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/compte.php');
            break;

      case 'logOut' :
            include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/logOut.php');
            break;
      
      case 'logIn' :
            include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/logIn.php');
            break;   

    default:
		include('view/accueil.php');
		break;
}