<?php

    function AbrirBD()
    {
        return mysqli_connect("127.0.0.1:3308","root","vetcaredb");
    }

    function CerrarBD($enlace)
    {
        mysqli_close($enlace);
    }

?>