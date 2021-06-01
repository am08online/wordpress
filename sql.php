<?php
if(isset($_GET["id"])){
    //die("Paramètre requis !");
    header("Location: sql.php");
}
        $host = 'localhost';
        $dbname = 'wp572';
        
        $dsn = 'mysql:host='.$host.';dbname='.$dbname;
        $user = 'root';
        $pwd = ''; 
        
        $options = array (
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    );

        
        // Connexion à la base de données
        try{
            $cnx = new PDO($dsn, $user, $pwd, $options);
            // echo 'Connexion réussie';


            $query = 'SELECT  wp572_posts.ID, post_title, post_content, post_date, display_name
                        FROM  wp572_posts, wp572_users
                        WHERE post_type="post" 
                        AND post_status="publish"
                        AND post_author=wp572_users.ID
                        ORDER BY post_date DESC';


            /*
            $query = 'SELECT post_title, LEFT(post_content,100) AS post_content_tr, post_date, display_name
                        FROM  wp572_posts, wp572_users
                        WHERE post_type="post" 
                        AND post_status="publish"
                        AND post_author=wp572_users.ID';
            */
            
            $req = $cnx->query($query);

            $req->setFetchMode(PDO::FETCH_ASSOC);
            //$req->SetFetchMode((PDO::FETCH-OBJ);
            //$req->SetFetchMode((PDO::FETCH-BOTH); 
            
            $tab = $req->fetchAll();

            $req->closeCursor();
            $cnx=null;
            // var_dump($tab);
            // Création Html

            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Liste d'articles- (sql.php)</title>
            </head>
            <body>
                <h1> Accueil du blog </h1>

            <?php    foreach($tab as $row) { ?>
               
                <!-- <h2><a href=article.php?id=<?=$row["post_title"]?> </a></h2> -->
                <h2><a href="article.php?id=<?=$row["ID"]?>"> <?=$row["post_title"]?> </a></h2>
                <p> <?=$row["post_content"]?> </p>
                <p> Auteur: <?=$row["display_name"]?>, Date: <?=$row["post_date"]?> </p>

                <?php } ?>

            </body>
            </html>

            <?php

/*
 // var_dump($rows);
            $tab = $cnx->query($req);

            foreach($tab as $row) {
                 var_dump($rows);
            }
            $cnx=null;
            echo "Fin du SQL !"; */
        }
            
        /*On capture les exceptions si une exception est lancée et on affiche
          *les informations relatives à celle-ci*/
        catch(PDOException $e){
             print "Erreur de connexion : " . $e->getMessage()."<br>";
             die();
        }


/*
        // Connexion à la bd
        try{
            $cnx = new PDO("mysql:host=$server;$dbname, $user, $pwd);
            //On définit le mode d'erreur de PDO sur Exception
            // $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion établie";
            */

/*
            $query = 'SELECT post_title, LEFT(post_content,100) AS post_content_tr, post_date, display_name
                        FROM  wp572_posts, wp572_users
                        WHERE post_type="post" 
                        AND post_status="publish"
                        AND post_author=wp572_users.ID';
            */
            
            $req = $cnx->query($query);



            echo "Fin du SQL !";
       // }
            
        /*On capture les exceptions si une exception est lancée et on affiche
          *les informations relatives à erreur de connexion/
        catch(PDOException $e){
             print "Erreur de requête: " . $e->getMessage(). "<br>";
        }
    */
?>