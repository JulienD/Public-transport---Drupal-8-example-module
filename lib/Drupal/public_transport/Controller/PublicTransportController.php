<?php
/**
 * @file
 * Contains \Drupal\public_transport\Controller\PublicTransportController.
 */

namespace Drupal\public_transport\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Show your a dummy content
 */
class PublicTransportController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function content() {

    // Start building the content.
    $build = array();

    $build = array(
      '#theme' => 'public_transport_page',
      '#content' => 'map',
    );

    // Attach a CSS file to show which line is output by which script.
    $build['#attached']['css'] = array(drupal_get_path('module', 'public_transport') . '/css/public_transport.css');

    // Generates Gmap script url.
    $config = $this->config('public_transport.settings');
    $gmap_script_url = url('https://maps.googleapis.com/maps/api/js?', array('query' => array('key' => $config->get('gmap_api_key'), 'sensor' => $config->get('gmap_api_sensor'))));

    // Attach some javascript files.
    $build['#attached']['js'] = array(
      array(
        'data' => $gmap_script_url,
        'type' => 'external',
      ),
      array(
        'data' => drupal_get_path('module', 'public_transport') . '/js/public_transport.js',
        'type' => 'file',
      ),
    );
    return $build;
  }

}