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

class HtmlrenderWebkitHeadlessProtoModalDialogEvent extends \Google\Model
{
  /**
   * @var bool
   */
  public $confirmed;
  /**
   * @var string
   */
  public $message;
  /**
   * @var string
   */
  public $result;
  /**
   * @var string
   */
  public $type;

  /**
   * @param bool
   */
  public function setConfirmed($confirmed)
  {
    $this->confirmed = $confirmed;
  }
  /**
   * @return bool
   */
  public function getConfirmed()
  {
    return $this->confirmed;
  }
  /**
   * @param string
   */
  public function setMessage($message)
  {
    $this->message = $message;
  }
  /**
   * @return string
   */
  public function getMessage()
  {
    return $this->message;
  }
  /**
   * @param string
   */
  public function setResult($result)
  {
    $this->result = $result;
  }
  /**
   * @return string
   */
  public function getResult()
  {
    return $this->result;
  }
  /**
   * @param string
   */
  public function setType($type)
  {
    $this->type = $type;
  }
  /**
   * @return string
   */
  public function getType()
  {
    return $this->type;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(HtmlrenderWebkitHeadlessProtoModalDialogEvent::class, 'Google_Service_Contentwarehouse_HtmlrenderWebkitHeadlessProtoModalDialogEvent');
