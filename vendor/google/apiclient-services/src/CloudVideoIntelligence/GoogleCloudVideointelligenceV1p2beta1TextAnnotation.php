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

namespace Google\Service\CloudVideoIntelligence;

class GoogleCloudVideointelligenceV1p2beta1TextAnnotation extends \Google\Collection
{
  protected $collection_key = 'segments';
  protected $segmentsType = GoogleCloudVideointelligenceV1p2beta1TextSegment::class;
  protected $segmentsDataType = 'array';
  /**
   * @var string
   */
  public $text;
  /**
   * @var string
   */
  public $version;

  /**
   * @param GoogleCloudVideointelligenceV1p2beta1TextSegment[]
   */
  public function setSegments($segments)
  {
    $this->segments = $segments;
  }
  /**
   * @return GoogleCloudVideointelligenceV1p2beta1TextSegment[]
   */
  public function getSegments()
  {
    return $this->segments;
  }
  /**
   * @param string
   */
  public function setText($text)
  {
    $this->text = $text;
  }
  /**
   * @return string
   */
  public function getText()
  {
    return $this->text;
  }
  /**
   * @param string
   */
  public function setVersion($version)
  {
    $this->version = $version;
  }
  /**
   * @return string
   */
  public function getVersion()
  {
    return $this->version;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudVideointelligenceV1p2beta1TextAnnotation::class, 'Google_Service_CloudVideoIntelligence_GoogleCloudVideointelligenceV1p2beta1TextAnnotation');
