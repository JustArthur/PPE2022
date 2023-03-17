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

    <link rel="stylesheet" href="../style/statistique.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <title>Stastistique</title>
</head>
    <?php
        require_once('src/navbar.php');
    ?>

    <main>
    <div>
    <canvas id="myChartPersonelle"></canvas>
    <canvas id="myChartOperation"></canvas>
    <canvas id="myChartOperationDate"></canvas>
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
      $date3 = $DB->prepare('SELECT from operations');
      $date3->execute();
      $oparationdates = $date3->fetchall();
      foreach($oparationdates as $oparationdate){

      }
    ?>
    </main>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>    
    <script>
    const ctxPersonnelle = document.getElementById('myChartPersonelle');
    const ctxOperation = document.getElementById('myChartOperation');
    const ctxOperationDate = document.getElementById('myChartOperationDate');
    new Chart(ctxPersonnelle, {
      type: 'bar',
      data: {
        labels: ['personnel '],
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
    new Chart(ctxOperation,{
        type: 'bar',
        data: {
            labels: ['operation'],
            datasets:[{
              data:[<?php echo $operation['id']?>],
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
<body>
    
</body>
</html>