<?php 

require 'vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client();

$crawler = $client->request('GET', 'http://koszalin.kiedyprzyjedzie.pl/departures?busStopDesignator=53');
$td = $crawler->filter('td')->each(function (Crawler $node, $i) {
    return $node->text();
});

foreach($td as $key => $value) {
    if($key % 3 === 0) {
        $przystanek_2[$key] = ['linia' => $td[$key], 'kierunek' => $td[$key + 1], 'odjazd' => $td[$key + 2]];
    }
} 

echo json_encode($przystanek_2);