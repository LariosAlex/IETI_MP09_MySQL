<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTINTENTS</title>
</head>
<body>
    <h1>Filtre de PAISOS per CONTINENTS</h1>
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

        function getTable($table){
            $query = connToDB()->prepare("select * FROM $table");
            return $query;
        }

        function selectDistinct($table, $filter){
            $query = connToDB()->prepare("select DISTINCT($table.$filter) FROM $table");
            return $query;
        }

        //CONSULTA
        //$countries = getTable('country');
        $continents = selectDistinct('country', 'Continent');
        $continents->execute();

        //ERRORS
        $e= $continents->errorInfo();
        if ($e[0]!='00000') {
        echo "\nPDO::errorInfo():\n";
        die("Error accedint a dades: " . $e[2]);
        }  
        
        //TRACTAMENT
        echo '<form id="buscarCiutats" action="index.php" method="post">';
            foreach($continents as $continent){
                echo '<label><input type="checkbox" name="continents[]" value="'.$continent['Continent'].'"> '.$continent['Continent'].'</label><br>';
            }
        echo '<input type="submit" value="Mostar paisos"></form>';

        if(isset($_POST['continents'])){
            $continents = [];
            foreach($_POST['continents'] as $continent){
                array_push($continents, "'$continent'");
            }
            $txtContinents = implode(", ", $continents);
            $cities = connToDB()->prepare("select * FROM country where country.Continent in (".$txtContinents.");");
            $cities->execute();
            echo "<ul>";
                foreach($cities as $city){
                    echo '<li>'.$city['Name'].'</li>';
                }
            echo "</ul>";
        }

    ?>
    
</body>
</html>