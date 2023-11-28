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

namespace Google\Service\Aiplatform;

class GoogleCloudAiplatformV1SchemaImageSegmentationAnnotationPolygonAnnotation extends \Google\Collection
{
  protected $collection_key = 'vertexes';
  /**
   * @var string
   */
  public $annotationSpecId;
  /**
   * @var string
   */
  public $displayName;
  protected $vertexesType = GoogleCloudAiplatformV1SchemaVertex::class;
  protected $vertexesDataType = 'array';

  /**
   * @param string
   */
  public function setAnnotationSpecId($annotationSpecId)
  {
    $this->annotationSpecId = $annotationSpecId;
  }
  /**
   * @return string
   */
  public function getAnnotationSpecId()
  {
    return $this->annotationSpecId;
  }
  /**
   * @param string
   */
  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }
  /**
   * @return string
   */
  public function getDisplayName()
  {
    return $this->displayName;
  }
  /**
   * @param GoogleCloudAiplatformV1SchemaVertex[]
   */
  public function setVertexes($vertexes)
  {
    $this->vertexes = $vertexes;
  }
  /**
   * @return GoogleCloudAiplatformV1SchemaVertex[]
   */
  public function getVertexes()
  {
    return $this->vertexes;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudAiplatformV1SchemaImageSegmentationAnnotationPolygonAnnotation::class, 'Google_Service_Aiplatform_GoogleCloudAiplatformV1SchemaImageSegmentationAnnotationPolygonAnnotation');
