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

class AttentionalEntitiesSemanticRoleId extends \Google\Model
{
  /**
   * @var string
   */
  public $intentId;
  /**
   * @var string
   */
  public $roleId;

  /**
   * @param string
   */
  public function setIntentId($intentId)
  {
    $this->intentId = $intentId;
  }
  /**
   * @return string
   */
  public function getIntentId()
  {
    return $this->intentId;
  }
  /**
   * @param string
   */
  public function setRoleId($roleId)
  {
    $this->roleId = $roleId;
  }
  /**
   * @return string
   */
  public function getRoleId()
  {
    return $this->roleId;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AttentionalEntitiesSemanticRoleId::class, 'Google_Service_Contentwarehouse_AttentionalEntitiesSemanticRoleId');
