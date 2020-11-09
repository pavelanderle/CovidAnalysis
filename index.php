<?php
    require_once("vendor/autoload.php");
    $latte = new Latte\Engine;

    $latte->setTempDirectory('temp');

    $conn = new mysqli("localhost", "root", "root", "covid");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SET CHARACTER SET UTF8";
    $result = $conn->query($sql);

    $sql = "SELECT kod,nazev FROM kraj";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $krajList[]=array($row["kod"],$row["nazev"]);
      }
    } else {
      echo "0 results";
    }

    if(isset($_GET["kraj"])){
        $kraj=$_GET["kraj"];


        $sql=[
        "SELECT COUNT(id) FROM Covid03_2020 WHERE kraj_nuts_kod='$kraj'",
        "SELECT COUNT(id) FROM Covid03_2020 WHERE kraj_nuts_kod='$kraj' AND pohlavi='M'",
        "SELECT COUNT(id) FROM Covid03_2020 WHERE kraj_nuts_kod='$kraj' AND pohlavi='Z'",
        "SELECT AVG(vek) FROM Covid03_2020 WHERE kraj_nuts_kod='$kraj'",
        "SELECT COUNT(id) FROM Covid03_2020 WHERE kraj_nuts_kod='$kraj' AND nakaza_v_zahranici='1'", 
        "SELECT nazev FROM kraj WHERE kod='$kraj'"  
        ];
        foreach ($sql as $item) {
            $result = $conn->query($item);
            $resultCovidInKraj[]=$result->fetch_array()[0];
        }
        $sql="SELECT nakaza_zeme_csu_kod,COUNT(id) FROM covid03_2020 WHERE kraj_nuts_kod='$kraj' GROUP BY nakaza_zeme_csu_kod";
        $result = $conn->query($sql);
        while ($row=$result->fetch_array()) {
            $resultImpactForeign[]=array($row[0]==""?"CZ":$row[0],$row[1]);
        }
    }
    else{
        $resultCovidInKraj=["0","0","0","0","0","Vyberte název kraje"];
        $resultImpactForeign=[];
    }
    $conn->close();
    
    $params = [
        'krajList' => $krajList,
        'resultCovidInKraj' => $resultCovidInKraj,
        'resultImpactForeign' => $resultImpactForeign
    ];
    
    // kresli na výstup
    $latte->render('templates/covidAnalysis.latte', $params);
?>