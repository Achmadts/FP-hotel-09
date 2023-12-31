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

class ShoppingWebentityShoppingAnnotationSoriVersionId extends \Google\Model
{
  /**
   * @var string
   */
  public $f1CommitTimestampMicros;
  /**
   * @var AdsShoppingReportingOffersSerializedSoriId
   */
  public $opaqueSoriId;
  protected $opaqueSoriIdType = AdsShoppingReportingOffersSerializedSoriId::class;
  protected $opaqueSoriIdDataType = '';

  /**
   * @param string
   */
  public function setF1CommitTimestampMicros($f1CommitTimestampMicros)
  {
    $this->f1CommitTimestampMicros = $f1CommitTimestampMicros;
  }
  /**
   * @return string
   */
  public function getF1CommitTimestampMicros()
  {
    return $this->f1CommitTimestampMicros;
  }
  /**
   * @param AdsShoppingReportingOffersSerializedSoriId
   */
  public function setOpaqueSoriId(AdsShoppingReportingOffersSerializedSoriId $opaqueSoriId)
  {
    $this->opaqueSoriId = $opaqueSoriId;
  }
  /**
   * @return AdsShoppingReportingOffersSerializedSoriId
   */
  public function getOpaqueSoriId()
  {
    return $this->opaqueSoriId;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ShoppingWebentityShoppingAnnotationSoriVersionId::class, 'Google_Service_Contentwarehouse_ShoppingWebentityShoppingAnnotationSoriVersionId');
