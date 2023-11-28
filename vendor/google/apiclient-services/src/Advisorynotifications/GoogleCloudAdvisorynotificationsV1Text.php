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

namespace Google\Service\Advisorynotifications;

class GoogleCloudAdvisorynotificationsV1Text extends \Google\Model
{
  /**
   * @var string
   */
  public $enText;
  /**
   * @var string
   */
  public $localizationState;
  /**
   * @var string
   */
  public $localizedText;

  /**
   * @param string
   */
  public function setEnText($enText)
  {
    $this->enText = $enText;
  }
  /**
   * @return string
   */
  public function getEnText()
  {
    return $this->enText;
  }
  /**
   * @param string
   */
  public function setLocalizationState($localizationState)
  {
    $this->localizationState = $localizationState;
  }
  /**
   * @return string
   */
  public function getLocalizationState()
  {
    return $this->localizationState;
  }
  /**
   * @param string
   */
  public function setLocalizedText($localizedText)
  {
    $this->localizedText = $localizedText;
  }
  /**
   * @return string
   */
  public function getLocalizedText()
  {
    return $this->localizedText;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudAdvisorynotificationsV1Text::class, 'Google_Service_Advisorynotifications_GoogleCloudAdvisorynotificationsV1Text');
