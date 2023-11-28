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

namespace Google\Service\CloudNaturalLanguage;

class ClassifyTextResponse extends \Google\Collection
{
  protected $collection_key = 'categories';
  protected $categoriesType = ClassificationCategory::class;
  protected $categoriesDataType = 'array';
  /**
   * @var string
   */
  public $languageCode;
  /**
   * @var bool
   */
  public $languageSupported;

  /**
   * @param ClassificationCategory[]
   */
  public function setCategories($categories)
  {
    $this->categories = $categories;
  }
  /**
   * @return ClassificationCategory[]
   */
  public function getCategories()
  {
    return $this->categories;
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
   * @param bool
   */
  public function setLanguageSupported($languageSupported)
  {
    $this->languageSupported = $languageSupported;
  }
  /**
   * @return bool
   */
  public function getLanguageSupported()
  {
    return $this->languageSupported;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ClassifyTextResponse::class, 'Google_Service_CloudNaturalLanguage_ClassifyTextResponse');
