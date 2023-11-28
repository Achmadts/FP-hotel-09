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

namespace Google\Service\MapsPlaces;

class GoogleMapsPlacesV1PlacePlusCode extends \Google\Model
{
  /**
   * @var string
   */
  public $compoundCode;
  /**
   * @var string
   */
  public $globalCode;

  /**
   * @param string
   */
  public function setCompoundCode($compoundCode)
  {
    $this->compoundCode = $compoundCode;
  }
  /**
   * @return string
   */
  public function getCompoundCode()
  {
    return $this->compoundCode;
  }
  /**
   * @param string
   */
  public function setGlobalCode($globalCode)
  {
    $this->globalCode = $globalCode;
  }
  /**
   * @return string
   */
  public function getGlobalCode()
  {
    return $this->globalCode;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleMapsPlacesV1PlacePlusCode::class, 'Google_Service_MapsPlaces_GoogleMapsPlacesV1PlacePlusCode');
