<?php

/**
 * @file
 * Contains \Drupal\public_transport\Plugin\Transport\Velib.
 */

namespace Drupal\public_transport\Plugin\Transport;

use Drupal\public_transport\Plugin\Transport\TransportPluginBase;
use Drupal\public_transport\Plugin\Transport\TransportPluginInterface;

/**
 * @Transport(
 *   id = "velib",
 *   label = @Translation("Velib")
 * )
 */
class Velib extends TransportPluginBase implements TransportPluginInterface {

  /**
   * Returns a string.
   */
  public function getStations() {
    return $this->getVelibStations();
  }

  /**
   * Returns a string.
   */
  public function getClosestStations($lat, $lng, $limit) {
    $output = array();
    $stations = array();
    $stations_list = $this->getStations();

    if ($stations_list && $lat && $lng) {

      foreach ($stations_list as $station) {
        $distance = $this->calculateDistance($lat, $lng, $station['position']['lat'], $station['position']['lng']);
        if ($distance) {
          $station['distance'] = $distance; // in kilometers
          $stations[] = $station;
        }
      }

      foreach ($stations as $key => $row) {
        $price[$key] = $row['distance'];
      }

      array_multisort($price, SORT_ASC, $stations);

      $output = array_slice($stations, 0, $limit);

    }
    return $output;
  }

  /**
   * @return mixed
   */
  function getVelibStations() {
    $api_key = 'baee86f3d72c1d607c8e2c83759458bad009c05a';

    // set HTTP header
    $headers = array(
      'Content-Type: application/json',
    );

    // query string
    $fields = array(
      'apiKey' => $api_key,
      'contract' => 'Paris',
    );
    $url = 'https://api.jcdecaux.com/vls/v1/stations?' . http_build_query($fields);

    // Open connection
    $ch = curl_init();

    // Set the url, number of GET vars, GET data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Execute request
    $result = curl_exec($ch);

    // Close connection
    curl_close($ch);

    return json_decode($result, true);
  }

}
