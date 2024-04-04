<?php

namespace Drupal\geo_type\GeoType;

use Drupal\search_api\DataType\DataTypePluginBase;

/**
 * Provides the WKT (Well-Known Text) data type.
 *
 * @SearchApiDataType(
 *   id = "wkt",
 *   label = @Translation("WKT"),
 *   description = @Translation("Well-Known Text (WKT) data type implementation"),
 *   fallback_type = "string",
 *   prefix = "rpt"
 * )
 */
class GeoType extends DataTypePluginBase {
}
