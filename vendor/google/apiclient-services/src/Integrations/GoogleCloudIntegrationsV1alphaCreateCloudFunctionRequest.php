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

namespace Google\Service\Integrations;

class GoogleCloudIntegrationsV1alphaCreateCloudFunctionRequest extends \Google\Model
{
  /**
   * @var string
   */
  public $functionName;
  /**
   * @var string
   */
  public $functionRegion;
  /**
   * @var string
   */
  public $projectId;

  /**
   * @param string
   */
  public function setFunctionName($functionName)
  {
    $this->functionName = $functionName;
  }
  /**
   * @return string
   */
  public function getFunctionName()
  {
    return $this->functionName;
  }
  /**
   * @param string
   */
  public function setFunctionRegion($functionRegion)
  {
    $this->functionRegion = $functionRegion;
  }
  /**
   * @return string
   */
  public function getFunctionRegion()
  {
    return $this->functionRegion;
  }
  /**
   * @param string
   */
  public function setProjectId($projectId)
  {
    $this->projectId = $projectId;
  }
  /**
   * @return string
   */
  public function getProjectId()
  {
    return $this->projectId;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudIntegrationsV1alphaCreateCloudFunctionRequest::class, 'Google_Service_Integrations_GoogleCloudIntegrationsV1alphaCreateCloudFunctionRequest');
