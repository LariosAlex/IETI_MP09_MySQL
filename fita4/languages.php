<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LANGUAGES</title>
</head>
<body>
    <h1>PAIS i el seu llenguatge</h1>
    <?php
        function connToDB(){
            try {
                $hostname = "localhost";
                $dbname = "world";
                $username = "admin";
                $pw = "admin123";
                $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
                } catch (PDOException $e) {
                echo "Failed to get DB handle: " . $e->getMessage() . "\n";
                exit;
                }
                return $pdo;
        }
    ?>      
    <form action="languages.php" method="post">
        <input type="text" name="pais" id="pais">
        <button type="submit">Buscar llenguatges</button>
    </form>
    <?php   
        if(isset($_POST['pais'])){
            $pais = $_POST['pais'];
            $languages = connToDB()->prepare("SELECT * FROM countrylanguage INNER JOIN country 
            ON countrylanguage.CountryCode = country.Code
            WHERE country.Name LIKE  CONCAT('%', '$pais', '%');");
            $languages->execute();
            
            echo "<br><table border='1px solid black';>";
            $currentCountry = '';
                foreach($languages as $language){
                    if($currentCountry != $language['CountryCode']){
                        echo "<tr>";
                            echo '<th colspan="3">'.$language['CountryCode'].'</th>'."\n";
                        echo "</tr>";
                        $currentCountry = $language['CountryCode'];
                    }
                    echo "<tr>";
                        echo '<td>'.$language['Language'].'</td>'."\n";
                        if($language['IsOfficial'] == 'T'){
                            echo '<td bgcolor="green">Oficial</td>'."\n";
                        }else{
                            echo '<td bgcolor="red">No Oficial</td>'."\n";
                        }
                        echo '<td>'.$language['Percentage'].'</td>'."\n";
                    echo "</tr>";
                }
            echo "</table>";
        }
    ?>    
</body>
</html>    