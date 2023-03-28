<?php
    include_once('../include.php');
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stastistique</title>
    <link rel="stylesheet" href="../style/statistique.css">
    <link rel="stylesheet" href="../style/navBar.css">
</head>
<body>
<?php
        require_once('src/navbar.php');
    ?>
<div>
    <div>
    <canvas id="myChartPersonelle"></canvas>
    <canvas id="myChartOperation"></canvas>
    </div>
    <?php

      $data1 = $DB->prepare('SELECT id,service From personnel');
      $data1->execute();
      $salaries = $data1->fetchall();
      foreach($salaries as $salarie){
      }

      $data2 = $DB->prepare('SELECT id FROM operations');
      $data2->execute();
      $operations = $data2->fetchall();
      foreach($operations as $operation){
      }

      $data3 = $DB->prepare('SELECT count(nomOperation) FROM operations where nomOperation = "Hospitalisation"');
      $data3->execute();
      $hospitalisations = $data3->fetchall();
      foreach($hospitalisations as $hospitalisation){
      }

      $data4 = $DB->prepare('SELECT count(nomOperation) FROM operations where nomOperation = "Ambulatoire chirugie"');
      $data4->execute();
      $Ambulatoires = $data4->fetchall();
      foreach($Ambulatoires as $Ambulatoire){
      }

      $date5 = $DB->prepare('SELECT count(YEAR(dateOperation)) FROM operations WHERE YEAR(dateOperation)=2023');
      $date5->execute();
      $dates2023 = $date5->fetchall();
      foreach($dates2023 as $date2023){
      }

      $date6 = $DB->prepare('SELECT count(YEAR(dateOperation)) FROM operations WHERE YEAR(dateOperation)=2022');
      $date6->execute();
      $dates2022 = $date6->fetchall();
      foreach($dates2022 as $date2022){
      }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>    
    <script>
    const ctxPersonnelle = document.getElementById('myChartPersonelle');
    const ctxOperation = document.getElementById('myChartOperation');
      // premier graphique //
    new Chart(ctxPersonnelle, {
      type: 'bar',
      data: {
        labels: ['personnel'],
        datasets: [{
          data: [<?php echo $salarie['id']; ?>],
        }]
      },    
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
      // deuxieme graphique // 
    new Chart(ctxOperation,{
        type: 'bar',
        data: {
            labels: ['operation'],
            datasets:[{
              data:[<?php echo $operation['id'];?>],
            }]
        },
        options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    </script>
    <select name="nomOperation">
    <?php
      $reponse = $DB->query('SELECT   DISTINCT nomOperation FROM operations');
      while($donnees = $reponse->fetch()){
    ?>
      <option value="<?php echo $donnees['nomOperation'];?>"><?php echo $donnees['nomOperation']?></option>
        
    <?php }?>
    </select>
    <div>
      <canvas id="myCharthospitalisation"></canvas>
      <canvas id="myChartAmbulatoire"></canvas>
    </div>
    <script>
    const ctxhospitalisation = document.getElementById('myCharthospitalisation');
    const ctxhAmbulatoire = document.getElementById('myChartAmbulatoire');
    // troisieme graphique // 
     new Chart(ctxhospitalisation,{
        type: 'bar',
        data: {
            labels: ['hospitalisation'],
            datasets:[{
              data:[<?php echo $hospitalisation['count(nomOperation)'];?>],
            }]
        },
        options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    // quatrieme graphique //
    new Chart(ctxhAmbulatoire,{
        type: 'bar',
        data: {
            labels: ['Ambulatoire chirugie'],
            datasets:[{
              data:[<?php echo $Ambulatoire['count(nomOperation)'];?>],
            }]
        },
        options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    </script>
     <select name="dateOperation">
    <?php
      $reponse = $DB->query('SELECT  DISTINCT YEAR(dateOperation) FROM operations');
      while($donnees = $reponse->fetch()){
    ?>
      <option value="<?php echo $donnees['YEAR(dateOperation)']; ?>"><?php echo $donnees['YEAR(dateOperation)']?></option>
    <?php }?>
    </select>
    <div>
      <canvas id="myChartDate2023"></canvas>
      <canvas id="myChartDate2022"></canvas>
    </div>
    <script>
    const ctxDate2023 = document.getElementById('myChartDate2023');
    const ctxhDate2022 = document.getElementById('myChartDate2022');
    // cinquieme graphique // 
     new Chart(ctxDate2023,{
        type: 'bar',
        data: {
            labels: ['date 2023'],
            datasets:[{
              data:[<?php echo $date2023['count(YEAR(dateOperation))'];?>],
            }]
        },
        options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    // sixieme  graphique //
    new Chart(ctxhDate2022,{
        type: 'bar',
        data: {
            labels: ['date 2022'],
            datasets:[{
              data:[<?php echo $date2022['count(YEAR(dateOperation))'];?>],
            }]
        },
        options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    </script>
    <script src="js/expireConnexion.js"></script>
  </body> 
</html>
