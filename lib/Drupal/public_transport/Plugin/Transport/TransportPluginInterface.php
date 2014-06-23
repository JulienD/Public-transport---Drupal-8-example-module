<?php
/**
 * @file
 * Contains \Drupal\public_transport\Plugin\TransportPluginInterface.
 */

namespace Drupal\public_transport\Plugin\Transport;

/**
 * Transport Plugin interface for providing some metadata inspection.
 *
 * This interface provides some simple function to ensure all the plugin
 * interact with the system correctly.
 */
interface TransportPluginInterface {

  /**
   * Returns all the stations of a public transport type.
   */
  public function getStations();

  /**
   * Returns a list of closest stations regarding a latitude and a longitude.
   *
   * @param string $lat
   *  A latitude value expressed in degrees.
   * @param string $lng
   *  A longitude value expressed in degrees.
   * @param integer $limit
   *  A value to limit the results.
   *
   * @return array
   *  Return a list of stations close to the given location.
   */
  public function getClosestStations($lat, $lng, $limit);

}


