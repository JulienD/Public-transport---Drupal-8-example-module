<?php

/**
 * @file
 * Contains \Drupal\public_transport\TransportPluginManager.
 */

namespace Drupal\public_transport;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Plugin\Discovery\ContainerDerivativeDiscoveryDecorator;
use Drupal\Core\Plugin\Factory\ContainerFactory;


/**
 * Transport plugin manager.
 */
class TransportPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {

    // Initialize the parent chain of objects.
    parent::__construct('Plugin/Transport', $namespaces, $module_handler,  'Drupal\public_transport\Annotation\Transport');

    // Configure the plugin manager.
    $this->setCacheBackend($cache_backend, $language_manager, 'transports');
    $this->alterInfo('transport_info');
  }

}



