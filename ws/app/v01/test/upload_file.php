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
        var_dump($_POST);
        /*
        Ejemplo: $_POST contiene:
        array(1) {
            ["filename"]=>
            string(8) "file.jpg"
        }
         */
        
        
        echo "<br/><br/>";
        var_dump($_FILES);
        
        /*
        Ejemplo: $_FILES contiene:
        array(1) {
            ["file"]=>
            array(5) {
                ["name"]=>
                string(21) "Close-up_of_a_cat.JPG"
                ["type"]=>
                string(19) "multipart/form-data"
                ["tmp_name"]=>
                string(36) "/Applications/MAMP/tmp/php/phpK3idGJ"
                ["error"]=>
                int(0)
                ["size"]=>
                int(2060705)
            }
        }
        */
        
        //Aqui renombramos el archivo que subimos usando el filename en $_POST,
        //pero podemos moverlo a otro directorio o insertarlo directamente en base de datos
        //http://www.w3schools.com/php/php_file_upload.asp
        move_uploaded_file($_FILES["file"]["tmp_name"], $_POST["filename"])
        ?>
    </body>
</html>
