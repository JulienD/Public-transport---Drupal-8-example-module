<?php
/**
 * @file
 * Contains \Drupal\public_transport\Controller\PublicTransportAjaxController.
 */

namespace Drupal\public_transport\Controller;

use Drupal\Core\Controller\ControllerBase;

//use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Show your a dummy content
 */
class PublicTransportAjaxController extends ControllerBase {
  /**
   * Loads and renders public transport stations via AJAX.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *  The current request object.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *  The response as ajax response.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   Thrown when the view was not found.
   */
  public function ajaxStation(Request $request, $transport) {
    $lat = $request->query->get('lat');
    $lng = $request->query->get('lng');

    if (!$limit = $request->query->get('limit')) {
      $limit = 2;
    }

    // Plugin should be passed as Dependency injection

    // Gets the plugin parameter
    if (isset($lat) && isset($lng)) {

      $transport_type = 'velib';
      // Gets the geolocation parameter
      // $definitions = \Drupal::service('plugin.manager.public_transport.transport')->getDefinitions();
      $definition = \Drupal::service('plugin.manager.public_transport.transport')->getDefinition($transport_type);
      $instance = \Drupal::service('plugin.manager.public_transport.transport')->createInstance($transport_type);

      $stations = $instance->getClosestStations($lat, $lng, $limit);

      $response = new AjaxResponse($stations, 200, array('content-type' => 'application/json'));
      return $response;
    }
    else {
      throw new NotFoundHttpException();
    }

  }

}