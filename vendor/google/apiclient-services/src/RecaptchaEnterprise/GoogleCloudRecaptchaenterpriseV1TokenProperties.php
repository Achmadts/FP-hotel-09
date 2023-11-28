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

namespace Google\Service\RecaptchaEnterprise;

class GoogleCloudRecaptchaenterpriseV1TokenProperties extends \Google\Model
{
  /**
   * @var string
   */
  public $action;
  /**
   * @var string
   */
  public $androidPackageName;
  /**
   * @var string
   */
  public $createTime;
  /**
   * @var string
   */
  public $hostname;
  /**
   * @var string
   */
  public $invalidReason;
  /**
   * @var string
   */
  public $iosBundleId;
  /**
   * @var bool
   */
  public $valid;

  /**
   * @param string
   */
  public function setAction($action)
  {
    $this->action = $action;
  }
  /**
   * @return string
   */
  public function getAction()
  {
    return $this->action;
  }
  /**
   * @param string
   */
  public function setAndroidPackageName($androidPackageName)
  {
    $this->androidPackageName = $androidPackageName;
  }
  /**
   * @return string
   */
  public function getAndroidPackageName()
  {
    return $this->androidPackageName;
  }
  /**
   * @param string
   */
  public function setCreateTime($createTime)
  {
    $this->createTime = $createTime;
  }
  /**
   * @return string
   */
  public function getCreateTime()
  {
    return $this->createTime;
  }
  /**
   * @param string
   */
  public function setHostname($hostname)
  {
    $this->hostname = $hostname;
  }
  /**
   * @return string
   */
  public function getHostname()
  {
    return $this->hostname;
  }
  /**
   * @param string
   */
  public function setInvalidReason($invalidReason)
  {
    $this->invalidReason = $invalidReason;
  }
  /**
   * @return string
   */
  public function getInvalidReason()
  {
    return $this->invalidReason;
  }
  /**
   * @param string
   */
  public function setIosBundleId($iosBundleId)
  {
    $this->iosBundleId = $iosBundleId;
  }
  /**
   * @return string
   */
  public function getIosBundleId()
  {
    return $this->iosBundleId;
  }
  /**
   * @param bool
   */
  public function setValid($valid)
  {
    $this->valid = $valid;
  }
  /**
   * @return bool
   */
  public function getValid()
  {
    return $this->valid;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudRecaptchaenterpriseV1TokenProperties::class, 'Google_Service_RecaptchaEnterprise_GoogleCloudRecaptchaenterpriseV1TokenProperties');
