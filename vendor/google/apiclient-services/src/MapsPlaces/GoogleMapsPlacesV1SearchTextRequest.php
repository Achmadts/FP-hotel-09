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

class GoogleMapsPlacesV1SearchTextRequest extends \Google\Collection
{
  protected $collection_key = 'priceLevels';
  /**
   * @var string
   */
  public $includedType;
  /**
   * @var string
   */
  public $languageCode;
  protected $locationBiasType = GoogleMapsPlacesV1SearchTextRequestLocationBias::class;
  protected $locationBiasDataType = '';
  protected $locationRestrictionType = GoogleMapsPlacesV1SearchTextRequestLocationRestriction::class;
  protected $locationRestrictionDataType = '';
  /**
   * @var int
   */
  public $maxResultCount;
  public $minRating;
  /**
   * @var bool
   */
  public $openNow;
  /**
   * @var string[]
   */
  public $priceLevels;
  /**
   * @var string
   */
  public $rankPreference;
  /**
   * @var string
   */
  public $regionCode;
  /**
   * @var bool
   */
  public $strictTypeFiltering;
  /**
   * @var string
   */
  public $textQuery;

  /**
   * @param string
   */
  public function setIncludedType($includedType)
  {
    $this->includedType = $includedType;
  }
  /**
   * @return string
   */
  public function getIncludedType()
  {
    return $this->includedType;
  }
  /**
   * @param string
   */
  public function setLanguageCode($languageCode)
  {
    $this->languageCode = $languageCode;
  }
  /**
   * @return string
   */
  public function getLanguageCode()
  {
    return $this->languageCode;
  }
  /**
   * @param GoogleMapsPlacesV1SearchTextRequestLocationBias
   */
  public function setLocationBias(GoogleMapsPlacesV1SearchTextRequestLocationBias $locationBias)
  {
    $this->locationBias = $locationBias;
  }
  /**
   * @return GoogleMapsPlacesV1SearchTextRequestLocationBias
   */
  public function getLocationBias()
  {
    return $this->locationBias;
  }
  /**
   * @param GoogleMapsPlacesV1SearchTextRequestLocationRestriction
   */
  public function setLocationRestriction(GoogleMapsPlacesV1SearchTextRequestLocationRestriction $locationRestriction)
  {
    $this->locationRestriction = $locationRestriction;
  }
  /**
   * @return GoogleMapsPlacesV1SearchTextRequestLocationRestriction
   */
  public function getLocationRestriction()
  {
    return $this->locationRestriction;
  }
  /**
   * @param int
   */
  public function setMaxResultCount($maxResultCount)
  {
    $this->maxResultCount = $maxResultCount;
  }
  /**
   * @return int
   */
  public function getMaxResultCount()
  {
    return $this->maxResultCount;
  }
  public function setMinRating($minRating)
  {
    $this->minRating = $minRating;
  }
  public function getMinRating()
  {
    return $this->minRating;
  }
  /**
   * @param bool
   */
  public function setOpenNow($openNow)
  {
    $this->openNow = $openNow;
  }
  /**
   * @return bool
   */
  public function getOpenNow()
  {
    return $this->openNow;
  }
  /**
   * @param string[]
   */
  public function setPriceLevels($priceLevels)
  {
    $this->priceLevels = $priceLevels;
  }
  /**
   * @return string[]
   */
  public function getPriceLevels()
  {
    return $this->priceLevels;
  }
  /**
   * @param string
   */
  public function setRankPreference($rankPreference)
  {
    $this->rankPreference = $rankPreference;
  }
  /**
   * @return string
   */
  public function getRankPreference()
  {
    return $this->rankPreference;
  }
  /**
   * @param string
   */
  public function setRegionCode($regionCode)
  {
    $this->regionCode = $regionCode;
  }
  /**
   * @return string
   */
  public function getRegionCode()
  {
    return $this->regionCode;
  }
  /**
   * @param bool
   */
  public function setStrictTypeFiltering($strictTypeFiltering)
  {
    $this->strictTypeFiltering = $strictTypeFiltering;
  }
  /**
   * @return bool
   */
  public function getStrictTypeFiltering()
  {
    return $this->strictTypeFiltering;
  }
  /**
   * @param string
   */
  public function setTextQuery($textQuery)
  {
    $this->textQuery = $textQuery;
  }
  /**
   * @return string
   */
  public function getTextQuery()
  {
    return $this->textQuery;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleMapsPlacesV1SearchTextRequest::class, 'Google_Service_MapsPlaces_GoogleMapsPlacesV1SearchTextRequest');
