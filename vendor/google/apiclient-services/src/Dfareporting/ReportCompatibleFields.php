<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Dfareporting;

class ReportCompatibleFields extends \Google\Collection
{
  protected $collection_key = 'pivotedActivityMetrics';
  /**
   * @var Dimension[]
   */
  public $dimensionFilters;
  protected $dimensionFiltersType = Dimension::class;
  protected $dimensionFiltersDataType = 'array';
  /**
   * @var Dimension[]
   */
  public $dimensions;
  protected $dimensionsType = Dimension::class;
  protected $dimensionsDataType = 'array';
  /**
   * @var string
   */
  public $kind;
  /**
   * @var Metric[]
   */
  public $metrics;
  protected $metricsType = Metric::class;
  protected $metricsDataType = 'array';
  /**
   * @var Metric[]
   */
  public $pivotedActivityMetrics;
  protected $pivotedActivityMetricsType = Metric::class;
  protected $pivotedActivityMetricsDataType = 'array';

  /**
   * @param Dimension[]
   */
  public function setDimensionFilters($dimensionFilters)
  {
    $this->dimensionFilters = $dimensionFilters;
  }
  /**
   * @return Dimension[]
   */
  public function getDimensionFilters()
  {
    return $this->dimensionFilters;
  }
  /**
   * @param Dimension[]
   */
  public function setDimensions($dimensions)
  {
    $this->dimensions = $dimensions;
  }
  /**
   * @return Dimension[]
   */
  public function getDimensions()
  {
    return $this->dimensions;
  }
  /**
   * @param string
   */
  public function setKind($kind)
  {
    $this->kind = $kind;
  }
  /**
   * @return string
   */
  public function getKind()
  {
    return $this->kind;
  }
  /**
   * @param Metric[]
   */
  public function setMetrics($metrics)
  {
    $this->metrics = $metrics;
  }
  /**
   * @return Metric[]
   */
  public function getMetrics()
  {
    return $this->metrics;
  }
  /**
   * @param Metric[]
   */
  public function setPivotedActivityMetrics($pivotedActivityMetrics)
  {
    $this->pivotedActivityMetrics = $pivotedActivityMetrics;
  }
  /**
   * @return Metric[]
   */
  public function getPivotedActivityMetrics()
  {
    return $this->pivotedActivityMetrics;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ReportCompatibleFields::class, 'Google_Service_Dfareporting_ReportCompatibleFields');
