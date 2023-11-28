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

class RepositoryWebrefLexicalRange extends \Google\Model
{
  /**
   * @var int
   */
  public $beginOffset;
  /**
   * @var string
   */
  public $category;
  /**
   * @var string
   */
  public $direction;
  /**
   * @var int
   */
  public $endOffset;
  /**
   * @var string
   */
  public $facetMid;

  /**
   * @param int
   */
  public function setBeginOffset($beginOffset)
  {
    $this->beginOffset = $beginOffset;
  }
  /**
   * @return int
   */
  public function getBeginOffset()
  {
    return $this->beginOffset;
  }
  /**
   * @param string
   */
  public function setCategory($category)
  {
    $this->category = $category;
  }
  /**
   * @return string
   */
  public function getCategory()
  {
    return $this->category;
  }
  /**
   * @param string
   */
  public function setDirection($direction)
  {
    $this->direction = $direction;
  }
  /**
   * @return string
   */
  public function getDirection()
  {
    return $this->direction;
  }
  /**
   * @param int
   */
  public function setEndOffset($endOffset)
  {
    $this->endOffset = $endOffset;
  }
  /**
   * @return int
   */
  public function getEndOffset()
  {
    return $this->endOffset;
  }
  /**
   * @param string
   */
  public function setFacetMid($facetMid)
  {
    $this->facetMid = $facetMid;
  }
  /**
   * @return string
   */
  public function getFacetMid()
  {
    return $this->facetMid;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(RepositoryWebrefLexicalRange::class, 'Google_Service_Contentwarehouse_RepositoryWebrefLexicalRange');
