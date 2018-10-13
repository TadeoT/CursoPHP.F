<?php
class peliculas_model
{
    public function todasLasPeliculas()
    {
        global $db;
        $sql="SELECT p.id_pelicula,`ge_nombre`,`di_nombreArtistico`,`pe_nombre`,`pe_duracion`,`pe_fechaEstreno`
                FROM pelicula p,genero g,director d
                WHERE p.id_genero = g.id_genero and p.id_director = d.id_director";
        $result=$db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function getAllPeliculas()
    {
        global $db;
        $sql = "SELECT p.id_pelicula,`ge_nombre`,`di_nombreArtistico`,`pe_nombre`,`pe_duracion`,`ac_nombreArtistico`,`pe_fechaEstreno`
                FROM pelicula p,genero g,director d,pelicula_actor pa,actor a
                WHERE p.id_genero = g.id_genero and p.id_director = d.id_director AND p.id_pelicula = pa.id_pelicula AND pa.id_actor = a.id_actor";
        $result = $db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function peliculasPorGenero()
    {
        global $db;
        $sql = "SELECT p.id_pelicula,`ge_nombre`,`di_nombreArtistico`,`pe_nombre`,`pe_duracion`,`ac_nombreArtistico`,`pe_fechaEstreno`
                FROM pelicula p,genero g,director d,pelicula_actor pa,actor a
                WHERE p.id_genero = g.id_genero and p.id_director = d.id_director AND p.id_pelicula = pa.id_pelicula AND pa.id_actor = a.id_actor
                ORDER BY ge_nombre";
        $result=$db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function peliculasPorDirector()
    {
        global $db;
        $sql = "SELECT p.id_pelicula,`ge_nombre`,`di_nombreArtistico`,`pe_nombre`,`pe_duracion`,`ac_nombreArtistico`,`pe_fechaEstreno`
                FROM pelicula p,genero g,director d,pelicula_actor pa,actor a
                WHERE p.id_genero = g.id_genero and p.id_director = d.id_director AND p.id_pelicula = pa.id_pelicula AND pa.id_actor = a.id_actor
                ORDER BY di_nombreArtistico";
        $result=$db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function eliminarPelicula($idPelicula)
    {
        global $db;
        $sql = "DELETE FROM `pelicula` WHERE `id_pelicula`= $idPelicula ";
        $result= $db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function eliminarActorPelicula($idPelicula)
    {
        global $db;
        $sql ="DELETE FROM pelicula_actor
               WHERE`id_pelicula`= $idPelicula";
        $result=$db->query($sql);
    }

    public function cambiarPelicula($nombre, $genero, $director, $duracion, $estreno, $id)
    {
        global $db;
        $sql = "UPDATE pelicula 
                SET id_genero = '$genero' ,id_director = '$director', pe_nombre = '$nombre' ,  pe_duracion = '$duracion', pe_fechaEstreno = '$estreno' 
                WHERE id_pelicula = $id";
        $result = $db->query($sql);
    }

   
    public function agregarPelicula($nombre, $genero, $director, $duracion, $estreno)
    {
        global $db;
        $sql = "INSERT INTO pelicula (id_genero, id_director,pe_nombre,pe_duracion,pe_fechaEstreno)
                VALUES ('$genero','$director','$nombre','$duracion','$estreno')";
        $result = $db->query($sql);
    }
    public function verGenero()
    {
        global $db;
        $sql = "SELECT * FROM genero";
        $result = $db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function verDirector()
    {
        global $db;
        $sql ="SELECT * FROM `director`";
        $result = $db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function verFiltros()
    {
        global $db;
        $sql="SELECT * FROM filtros ";
        $result = $db->query($sql);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function cargarCampos($id)
    {
        global $db;
        $sql="SELECT p.id_pelicula,`ge_nombre`,`di_nombreArtistico`,`pe_nombre`,`pe_duracion`,`pe_fechaEstreno`,g.id_genero,d.id_director
              FROM pelicula p,genero g,director d 
              WHERE p.id_genero = g.id_genero and p.id_director = d.id_director and p.id_pelicula = $id";
        $result = $db->query($sql);

        return $result;
    }
}
