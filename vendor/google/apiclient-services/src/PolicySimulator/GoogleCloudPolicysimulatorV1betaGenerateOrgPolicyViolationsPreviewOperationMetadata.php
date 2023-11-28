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

namespace Google\Service\PolicySimulator;

class GoogleCloudPolicysimulatorV1betaGenerateOrgPolicyViolationsPreviewOperationMetadata extends \Google\Model
{
  /**
   * @var string
   */
  public $requestTime;
  /**
   * @var int
   */
  public $resourcesFound;
  /**
   * @var int
   */
  public $resourcesPending;
  /**
   * @var int
   */
  public $resourcesScanned;
  /**
   * @var string
   */
  public $startTime;
  /**
   * @var string
   */
  public $state;

  /**
   * @param string
   */
  public function setRequestTime($requestTime)
  {
    $this->requestTime = $requestTime;
  }
  /**
   * @return string
   */
  public function getRequestTime()
  {
    return $this->requestTime;
  }
  /**
   * @param int
   */
  public function setResourcesFound($resourcesFound)
  {
    $this->resourcesFound = $resourcesFound;
  }
  /**
   * @return int
   */
  public function getResourcesFound()
  {
    return $this->resourcesFound;
  }
  /**
   * @param int
   */
  public function setResourcesPending($resourcesPending)
  {
    $this->resourcesPending = $resourcesPending;
  }
  /**
   * @return int
   */
  public function getResourcesPending()
  {
    return $this->resourcesPending;
  }
  /**
   * @param int
   */
  public function setResourcesScanned($resourcesScanned)
  {
    $this->resourcesScanned = $resourcesScanned;
  }
  /**
   * @return int
   */
  public function getResourcesScanned()
  {
    return $this->resourcesScanned;
  }
  /**
   * @param string
   */
  public function setStartTime($startTime)
  {
    $this->startTime = $startTime;
  }
  /**
   * @return string
   */
  public function getStartTime()
  {
    return $this->startTime;
  }
  /**
   * @param string
   */
  public function setState($state)
  {
    $this->state = $state;
  }
  /**
   * @return string
   */
  public function getState()
  {
    return $this->state;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudPolicysimulatorV1betaGenerateOrgPolicyViolationsPreviewOperationMetadata::class, 'Google_Service_PolicySimulator_GoogleCloudPolicysimulatorV1betaGenerateOrgPolicyViolationsPreviewOperationMetadata');
