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

namespace Google\Service\Vision;

class ProductSearchParams extends \Google\Collection
{
  protected $collection_key = 'productCategories';
  /**
   * @var BoundingPoly
   */
  public $boundingPoly;
  protected $boundingPolyType = BoundingPoly::class;
  protected $boundingPolyDataType = '';
  /**
   * @var string
   */
  public $filter;
  /**
   * @var string[]
   */
  public $productCategories;
  /**
   * @var string
   */
  public $productSet;

  /**
   * @param BoundingPoly
   */
  public function setBoundingPoly(BoundingPoly $boundingPoly)
  {
    $this->boundingPoly = $boundingPoly;
  }
  /**
   * @return BoundingPoly
   */
  public function getBoundingPoly()
  {
    return $this->boundingPoly;
  }
  /**
   * @param string
   */
  public function setFilter($filter)
  {
    $this->filter = $filter;
  }
  /**
   * @return string
   */
  public function getFilter()
  {
    return $this->filter;
  }
  /**
   * @param string[]
   */
  public function setProductCategories($productCategories)
  {
    $this->productCategories = $productCategories;
  }
  /**
   * @return string[]
   */
  public function getProductCategories()
  {
    return $this->productCategories;
  }
  /**
   * @param string
   */
  public function setProductSet($productSet)
  {
    $this->productSet = $productSet;
  }
  /**
   * @return string
   */
  public function getProductSet()
  {
    return $this->productSet;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ProductSearchParams::class, 'Google_Service_Vision_ProductSearchParams');
