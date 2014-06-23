<?php
/**
 * @file
 * Contains \Drupal\public_transport\Annotation\Transport.
 */

namespace Drupal\public_transport\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a transport annotation object.
 *
 * @Annotation
 */
class Transport extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the datasource plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

}



