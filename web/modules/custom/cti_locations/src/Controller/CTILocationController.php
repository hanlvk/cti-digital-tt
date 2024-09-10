<?php

namespace Drupal\cti_locations\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides route responses for the Example module.
 */
#[\AllowDynamicProperties]
class CTILocationController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    protected EntityTypeManager $entity_type_manager,
  ) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function showLocations() {
    $locations = $this->readLocations();

    $build = [
      #'#title' => $this->t('Poland cities'),
      '#theme' => 'cti_locations_poland',
      '#locations' => $locations,
      '#cache' => [
        'tags' => ['node_list:location'],
      ],
    ];

    $build['#attached']['drupalSettings']['cti_locations']['locations'] = $locations;

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function readLocations() {
    $entity_type = 'location';
    $entities = $this->entityTypeManager->getStorage('node')->loadByProperties(['type' => $entity_type]);

    $locations = [];
    foreach ($entities as $entity) {
      $locations[$entity->title->getString()] = [
        'latitude' => $entity->field_latitude->getString(),
        'longitude' => $entity->field_longitude->getString(),
      ];
    }

    return $locations;
  }

}
