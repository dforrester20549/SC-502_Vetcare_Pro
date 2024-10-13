<?php

    function AbrirBD()
    {
        return mysqli_connetc("127.0.0.1:3308","root","vetcaredb");
    }

    function CerrarBD($enlace)
    {
        mysqli_close($enlace);
    }

?>