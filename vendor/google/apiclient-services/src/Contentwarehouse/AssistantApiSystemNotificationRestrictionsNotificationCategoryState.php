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

class AssistantApiSystemNotificationRestrictionsNotificationCategoryState extends \Google\Model
{
  /**
   * @var int
   */
  public $categoryId;
  /**
   * @var bool
   */
  public $disabled;
  /**
   * @var string
   */
  public $disabledReason;

  /**
   * @param int
   */
  public function setCategoryId($categoryId)
  {
    $this->categoryId = $categoryId;
  }
  /**
   * @return int
   */
  public function getCategoryId()
  {
    return $this->categoryId;
  }
  /**
   * @param bool
   */
  public function setDisabled($disabled)
  {
    $this->disabled = $disabled;
  }
  /**
   * @return bool
   */
  public function getDisabled()
  {
    return $this->disabled;
  }
  /**
   * @param string
   */
  public function setDisabledReason($disabledReason)
  {
    $this->disabledReason = $disabledReason;
  }
  /**
   * @return string
   */
  public function getDisabledReason()
  {
    return $this->disabledReason;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AssistantApiSystemNotificationRestrictionsNotificationCategoryState::class, 'Google_Service_Contentwarehouse_AssistantApiSystemNotificationRestrictionsNotificationCategoryState');
