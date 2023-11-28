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

class QualitySnippetsTruncationSnippetBoldedRangePosition extends \Google\Model
{
  /**
   * @var int
   */
  public $byteOffset;
  /**
   * @var int
   */
  public $index;

  /**
   * @param int
   */
  public function setByteOffset($byteOffset)
  {
    $this->byteOffset = $byteOffset;
  }
  /**
   * @return int
   */
  public function getByteOffset()
  {
    return $this->byteOffset;
  }
  /**
   * @param int
   */
  public function setIndex($index)
  {
    $this->index = $index;
  }
  /**
   * @return int
   */
  public function getIndex()
  {
    return $this->index;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(QualitySnippetsTruncationSnippetBoldedRangePosition::class, 'Google_Service_Contentwarehouse_QualitySnippetsTruncationSnippetBoldedRangePosition');
