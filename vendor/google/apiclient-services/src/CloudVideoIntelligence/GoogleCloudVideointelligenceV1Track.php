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

class GoogleCloudVideointelligenceV1Track extends \Google\Collection
{
  protected $collection_key = 'timestampedObjects';
  protected $attributesType = GoogleCloudVideointelligenceV1DetectedAttribute::class;
  protected $attributesDataType = 'array';
  /**
   * @var float
   */
  public $confidence;
  protected $segmentType = GoogleCloudVideointelligenceV1VideoSegment::class;
  protected $segmentDataType = '';
  protected $timestampedObjectsType = GoogleCloudVideointelligenceV1TimestampedObject::class;
  protected $timestampedObjectsDataType = 'array';

  /**
   * @param GoogleCloudVideointelligenceV1DetectedAttribute[]
   */
  public function setAttributes($attributes)
  {
    $this->attributes = $attributes;
  }
  /**
   * @return GoogleCloudVideointelligenceV1DetectedAttribute[]
   */
  public function getAttributes()
  {
    return $this->attributes;
  }
  /**
   * @param float
   */
  public function setConfidence($confidence)
  {
    $this->confidence = $confidence;
  }
  /**
   * @return float
   */
  public function getConfidence()
  {
    return $this->confidence;
  }
  /**
   * @param GoogleCloudVideointelligenceV1VideoSegment
   */
  public function setSegment(GoogleCloudVideointelligenceV1VideoSegment $segment)
  {
    $this->segment = $segment;
  }
  /**
   * @return GoogleCloudVideointelligenceV1VideoSegment
   */
  public function getSegment()
  {
    return $this->segment;
  }
  /**
   * @param GoogleCloudVideointelligenceV1TimestampedObject[]
   */
  public function setTimestampedObjects($timestampedObjects)
  {
    $this->timestampedObjects = $timestampedObjects;
  }
  /**
   * @return GoogleCloudVideointelligenceV1TimestampedObject[]
   */
  public function getTimestampedObjects()
  {
    return $this->timestampedObjects;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudVideointelligenceV1Track::class, 'Google_Service_CloudVideoIntelligence_GoogleCloudVideointelligenceV1Track');
