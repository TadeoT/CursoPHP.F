<?php
include_once("inc.includes.php");
class peliculas_Controller
{
    public function mostrarPelicula()
    {
        //HTML INICIADO
        $tpl = new TemplatePower("templates/listadoPeliculas.html");
        $tpl->prepare();
        $tpl -> gotoBlock("_ROOT");

        //INICIO DE LLAMADA A BASE DE DATOS
        $peliculas = new peliculas_model();
        
        $listadoFiltros = $peliculas->verFiltros();
        //FILTROS
        $tpl -> assign("titulo", "Listado Peliculas");
        if ($listadoFiltros) {
            foreach ($listadoFiltros as $data) {
                $tpl->newBlock("filtros");
                $tpl->assign("valor_filtro", $data ["nombre_filtro"]);
            }
        }

        //Recibe El resultado del filtro
        if ((isset($_REQUEST["sel_categoria"]))) {
            $filtro = $_REQUEST['sel_categoria'];
        }

        if ((!isset($_REQUEST["sel_categoria"])) || ($_REQUEST["sel_categoria"] == "")|| ($filtro ==="NoActores")) {
            $listadoPelicula = $peliculas->todasLasPeliculas();
            if (isset($listadoPelicula)) {
                foreach ($listadoPelicula as $data) {
                    $tpl->newBlock("block_listado_peliculas");
                    $tpl->assign("var_list_nombre", $data ["pe_nombre"]);
                    $tpl->assign("var_list_genero", $data ["ge_nombre"]);
                    $tpl->assign("var_list_director", $data ["di_nombreArtistico"]);
                    $tpl->assign("var_list_duracion", $data ["pe_duracion"]);
                    $tpl->assign("var_list_fecha", $data["pe_fechaEstreno"]);
                    $tpl->assign("var_list_id", $data["id_pelicula"]);
                }
            }
        } else {

            //Muestra Pelicula Segun Filtros
        
            if ($filtro === "Nombre") {
                $listadoPelicula = $peliculas->getAllPeliculas();
            }
            if ($filtro === "Genero") {
                $listadoPelicula = $peliculas->peliculasPorGenero();
            }
            if ($filtro === "Director") {
                $listadoPelicula = $peliculas->peliculasPorDirector();
            }
            foreach ($listadoPelicula as $data) {
                $tpl->newBlock("block_listado_peliculas");
                $tpl->assign("var_list_nombre", $data ["pe_nombre"]);
                $tpl->assign("var_list_genero", $data ["ge_nombre"]);
                $tpl->assign("var_list_director", $data ["di_nombreArtistico"]);
                $tpl->assign("var_list_duracion", $data ["pe_duracion"]);
                $tpl->assign("var_list_actores", $data ["ac_nombreArtistico"]);
                $tpl->assign("var_list_fecha", $data["pe_fechaEstreno"]);
                $tpl->assign("var_list_id", $data["id_pelicula"]);
            }
        }

        return $tpl->getOutputContent();
    }
    public function eliminarPelicula()
    {
        $peliculas = new peliculas_model();

        $id=$_GET['id'];

        $peliculas -> eliminarPelicula($id);
        if ($peliculas==false) {
            return "No se pudo eliminar la pelicula";
        }

        $peliculas -> eliminarActorPelicula($id);

        return  $this->mostrarPelicula();
    }
    public function cambioPelicula()
    {
        $tpl = new TemplatePower("./templates/cambioPelicula.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        $peliculas = new peliculas_model;
        $id=$_GET['id'];
        
        $datosPeli = $peliculas->cargarCampos($id);
        if (isset($datosPeli)) {
            foreach ($datosPeli as $data) {
                $tpl->assign("p_nombre", $data['pe_nombre']);
                $tpl->assign("p_duracion", $data['pe_duracion']);
                $tpl->assign("p_estreno", $data['pe_fechaEstreno']);
                $genero = $data['id_genero'];
                $director = $data['id_director'];
            }
        }
        $tpl->assign("id_p", $id);
        $listadoGenero = $peliculas->verGenero();
        if (isset($listadoGenero)) {
            foreach ($listadoGenero as $data) {
                $tpl->newBlock("genero");
                $tpl->assign("id_genero", $data['id_genero']);
                if ($genero == $data['id_genero']) {
                    $tpl->assign("var_select_g", "selected");
                } else {
                    $tpl->assign("var_select_g", "");
                }
                $tpl->assign("generos", $data['ge_nombre']);
            }
        }
        $listadoDirector = $peliculas->verDirector();
        if (isset($listadoDirector)) {
            foreach ($listadoDirector as $data) {
                $tpl->newBlock("director");
                $tpl->assign("id_director", $data['id_director']);
                if ($director == $data['id_director']) {
                    $tpl->assign("var_select_d", "selected");
                } else {
                    $tpl->assign("var_select_d", "");
                }

                $tpl->assign("directores", $data['di_nombreArtistico']);
            }
        }
        return $tpl->getOutputContent();
    }
    public function cambiarPelicula()
    {
        $peliculas = new peliculas_model();

        $nombre =$_REQUEST['nombrePelicula'];
        $genero =$_REQUEST['genero'];
        $director =$_REQUEST['director'];
        $duracion =$_REQUEST['duracion'];
        $estreno =$_REQUEST['fechaEstreno'];
        $id= $_REQUEST['id_p'];


        $peliculas -> cambiarPelicula($nombre, $genero, $director, $duracion, $estreno, $id);
        return  $this->mostrarPelicula();
    }
    public function agregarPelicula()
    {
        $peliculas = new peliculas_model();
        $nombre =$_REQUEST['nombrePelicula'];
        $genero =$_REQUEST['genero'];
        $director =$_REQUEST['director'];
        $duracion =$_REQUEST['duracion'];
        $estreno =$_REQUEST['fechaEstreno'];

        $peliculas->agregarPelicula($nombre, $genero, $director, $duracion, $estreno);
        return  $this->mostrarPelicula();
    }
    public function altaPelicula()
    {
        $tpl = new TemplatePower("./templates/altaPelicula.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");

        $peliculas = new peliculas_model;
        $listadoGenero = $peliculas->verGenero();
        foreach ($listadoGenero as $data) {
            $tpl->newBlock("genero");
            $tpl->assign("id_genero", $data['id_genero']);
            $tpl->assign("generos", $data['ge_nombre']);
        }

        $listadoDirector = $peliculas->verDirector();
        foreach ($listadoDirector as $data) {
            $tpl->newBlock("director");
            $tpl->assign("id_director", $data['id_director']);
            $tpl->assign("directores", $data['di_nombreArtistico']);
        }

        return $tpl->getOutputContent();
    }
}
