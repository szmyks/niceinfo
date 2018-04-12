<?php 

    /**
     * Stworzone przez Szymon Tomczyk
     * E-mail: <szymon.tomczyk26@gmail.com>
     * Version: 1.2.0
     * Version date: 12-04-2018
     */

    require 'vendor/autoload.php';
    use Goutte\Client;
    use Symfony\Component\DomCrawler\Crawler;

    $client = new Client();

    $crawler = $client->request('GET', 'http://zmiany.zs9elektronik.pl/');
    $crawler = $crawler->filter('td')->each(function (Crawler $node, $i) {
        return $node->text();
    });

    $tytul_zmian = $crawler[0];
    unset($crawler[0]);
    $zmiany = array();
    foreach ($crawler as $key => $value) {
        if ($key % 2 !== 0) {
            $klasa = $crawler[$key];
            $zmiana = $crawler[$key + 1];
            $zmiany[$klasa] = $zmiana;
        }
    }

    $crawler = $client->request('GET', 'http://zs9elektronik.pl/sn.php');
    $sn = $crawler->text();
    $pieces = explode("|", $sn);

     
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>[Nice Info App] v1.2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <!-- /Css -->
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
    <!-- /Fonts -->

</head>
<body>

    <!-- strona z rozkladami mzk http://koszalin.kiedyprzyjedzie.pl -->
    <!-- http://koszalin.kiedyprzyjedzie.pl/departures?busStopDesignator=40 Clausisa 01 -->
    <!-- http://koszalin.kiedyprzyjedzie.pl/departures?busStopDesignator=53 Clausisa 02 -->

    <div class="container-fluid" id="main" style="margin-top: 15px;">

        
        <div class="row">
            <!-- left side -->
            <div class="col-md-5">

                <div class="row">
                    <div class="col-md-12 text-center">
                        
                        <h2>Przystanki MZK</h2>

                    </div>
                </div>
                
                <!-- rozklad #1 -->
                <div class="row">
                    <div class="col-md-12 text-center">

                        <h3>Clausiusa / 01</h3>

                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>linia</th>
                                    <th>kierunek</th>
                                    <th>odjazd</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($przystanek_1 as $key => $przystanek) {?>
                                    <tr>
                                        <td><?= $przystanek['linia'] ?></td>
                                        <td><?= $przystanek['kierunek'] ?></td>
                                        <td><?= $przystanek['odjazd'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- /rozklad #1 -->

                <!-- rozklad #2 -->
                <div class="row">
                    <div class="col-md-12 text-center">

                       <h3>Clausiusa / 02</h3>

                       <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>linia</th>
                                    <th>kierunek</th>
                                    <th>odjazd</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($przystanek_2 as $key => $przystanek) {?>
                                    <tr>
                                        <td><?= $przystanek['linia'] ?></td>
                                        <td><?= $przystanek['kierunek'] ?></td>
                                        <td><?= $przystanek['odjazd'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- /rozklad #2 -->

                <!-- godzina -->
                <div class="row mt-3">
                    <div class="col-md-4 text-center">

                        <span style="font-size: 1.5em;">Szczęśliwy numerek:</span><br>
                
                        <span style="font-size: 5.5em;"><?= $pieces[0] ?></span><br>

                        <span style="font-size: 1.5em;"><?= $pieces[1] ?></span>

                    </div>
                    <div class="col-md-8 text-center">

                        <span style="font-size: 6.5em;" id="aktualna_godzina"></span>

                    </div>
                </div>
                <!-- /godzina -->

            </div>
            <!-- /left side -->

            <!-- right side -->
            <div class="col-md-7">
            
                <!-- zmiany -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3><?php echo $tytul_zmian; ?></h3>
                    </div>
                </div>

                <div class="zmiany">
                    <table class="table">
                        <tbody>
                            <?php foreach ($zmiany as $key => $value) { ?>

                                <?php if ($value !== '') { ?>

                                    <tr>
                                        <td><b><?php echo $key; ?></b></td>
                                        <td><?php echo $value; ?></td>
                                    </tr>
                                
                                <?php } ?>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /zmiany -->

                <div class="row">
                    <div class="col-md-12 text-center">
                        <img style="height: 20%; width: auto;" src="img/zs9_logo.png" alt="zs9-logo">
                    </div>
                </div>

            </div>
            <!-- /right side -->
    
        </div>

        <!-- footer -->
        <div class="row">
            <div class="col-md-12 text-center">
                
                <p>Stworzone przez <span style="border-bottom: 1px dotted #ccc;">Szymona Tomczyka</span> &copy 2018</p>

            </div>
        </div>
        <!-- /footer -->

    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            
            function getActualTime() {

                var date = new Date;
                var seconds = date.getSeconds();
                var minutes = date.getMinutes();
                var hours = date.getHours();

                if (seconds < 10) { seconds = `0${seconds}`; }
                if (minutes < 10) { minutes = `0${minutes}`; }
                if (hours < 10) { hours = `0${hours}`; }

                var aktualna_godzina = `${hours}:${minutes}:${seconds}`;

                $('#aktualna_godzina').html(aktualna_godzina);
            }

            setInterval(function() {
                getActualTime();
            }, 1000);

            // AJAX POBIERANIE PRZYSTANKOW CO MINUTKE

            $.ajax({
                url: 'busstop_1.php'
            })
            .done(function(data) {
                // data.forEach(function(value, index) {
                //     console.log(value['linia']);
                // });
                var przystanek_1 = JSON.parse(data);

                console.log(przystanek_1[0].linia);
            });

            $.ajax({
                url: 'busstop_2.php'
            })
            .done(function(data) {
                var przystanek_2 = data;
            });

            // PRZYSTANEK CLAUSIUSA 01
            setInterval(function() {
                $.ajax({
                    url: 'busstop_1.php'
                })
                .done(function(data) {
                    var przystanek_1 = data;
                });
            }, 60000);

            // PRZYSTANEK CLAUSIUSA 02
            setInterval(function() {
                $.ajax({
                    url: 'busstop_2.php'
                })
                .done(function(data) {
                    var przystanek_2 = data;
                });
            }, 60000);
        });
    </script>

</body>
</html>
