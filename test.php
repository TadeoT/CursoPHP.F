<?php
include_once("inc.includes.php");
$db = new MySQL($config["dbhost"], $config["dbuser"], $config["dbpass"], $config["db"]);
$peliculas_vista = new peliculas_controler();
$peliculas = $peliculas_vista -> mostrarPelicula();
$peliculasPorGenero = $peliculas_vista -> peliculasPorGenero();
echo $peliculas;
