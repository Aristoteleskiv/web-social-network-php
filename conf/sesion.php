<?php

session_start(); 

//if(!isset($_SESSION["usr"])){$_SESSION["usr"]="dani";}

//if(!isset($_SESSION["publi"])){$_SESSION["publi"]=  getPublicidadUsuario($_SESSION["usr"]);}

if(!isset($_SESSION["contPubli"])){$_SESSION["contPubli"]=0;}

//echo $_SESSION["contPubli"];
//var_dump($_SESSION);