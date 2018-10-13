<?php
    include_once("inc.configuration.php");

    include_once("recursos/_php/class.mysqli.php");
    include_once("recursos/_php/utils.php");
    
    // Controllers
    include_once("pelicula.controler.php");
    include_once("ingreso.controler.php");
    // Models
    include_once("pelicula.model.php");
    //Vista
    include_once("recursos/_php/class.TemplatePower.inc.php");
    //include controlador frontal
    include_once("index.php");
