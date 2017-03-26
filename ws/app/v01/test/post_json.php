<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        /*Ejemplo: Mandamos por post el siguiente JSON:
        
        {
            "classroomID":"5c7e21fd443d4eee947467629923658a",
            "username":"frajimenez"
        }
        
        */
        
        //Tomamos el contenido del post
        $json = file_get_contents('php://input');
        //Asumimos que es un json y lo decodificamos (por buenas practicas deberia estar en un try/catch)
        $obj = json_decode($json);
        
        //Podemos acceder a las propiedades del objeto con el mismo nombre que utiliza el json
        //http://stackoverflow.com/questions/18866571/receive-json-post-with-php
        echo "ID: ".$obj->idPerfil."<br/>";
        echo "Perfil: ".$obj->Perfil."<br/><br/>";
        ?>
    </body>
</html>
