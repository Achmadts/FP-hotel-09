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

namespace Google\Service\Contentwarehouse;

class NlpSemanticParsingLocalVicinityLocation extends \Google\Model
{
  /**
   * @var NlpSemanticParsingLocalLocation
   */
  public $base;
  protected $baseType = NlpSemanticParsingLocalLocation::class;
  protected $baseDataType = '';
  /**
   * @var string
   */
  public $connector;
  /**
   * @var NlpSemanticParsingLocalExtent
   */
  public $extent;
  protected $extentType = NlpSemanticParsingLocalExtent::class;
  protected $extentDataType = '';

  /**
   * @param NlpSemanticParsingLocalLocation
   */
  public function setBase(NlpSemanticParsingLocalLocation $base)
  {
    $this->base = $base;
  }
  /**
   * @return NlpSemanticParsingLocalLocation
   */
  public function getBase()
  {
    return $this->base;
  }
  /**
   * @param string
   */
  public function setConnector($connector)
  {
    $this->connector = $connector;
  }
  /**
   * @return string
   */
  public function getConnector()
  {
    return $this->connector;
  }
  /**
   * @param NlpSemanticParsingLocalExtent
   */
  public function setExtent(NlpSemanticParsingLocalExtent $extent)
  {
    $this->extent = $extent;
  }
  /**
   * @return NlpSemanticParsingLocalExtent
   */
  public function getExtent()
  {
    return $this->extent;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(NlpSemanticParsingLocalVicinityLocation::class, 'Google_Service_Contentwarehouse_NlpSemanticParsingLocalVicinityLocation');
