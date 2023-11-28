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

namespace Google\Service\Compute;

class AccessConfig extends \Google\Model
{
  /**
   * @var string
   */
  public $externalIpv6;
  /**
   * @var int
   */
  public $externalIpv6PrefixLength;
  /**
   * @var string
   */
  public $kind;
  /**
   * @var string
   */
  public $name;
  /**
   * @var string
   */
  public $natIP;
  /**
   * @var string
   */
  public $networkTier;
  /**
   * @var string
   */
  public $publicPtrDomainName;
  /**
   * @var string
   */
  public $securityPolicy;
  /**
   * @var bool
   */
  public $setPublicPtr;
  /**
   * @var string
   */
  public $type;

  /**
   * @param string
   */
  public function setExternalIpv6($externalIpv6)
  {
    $this->externalIpv6 = $externalIpv6;
  }
  /**
   * @return string
   */
  public function getExternalIpv6()
  {
    return $this->externalIpv6;
  }
  /**
   * @param int
   */
  public function setExternalIpv6PrefixLength($externalIpv6PrefixLength)
  {
    $this->externalIpv6PrefixLength = $externalIpv6PrefixLength;
  }
  /**
   * @return int
   */
  public function getExternalIpv6PrefixLength()
  {
    return $this->externalIpv6PrefixLength;
  }
  /**
   * @param string
   */
  public function setKind($kind)
  {
    $this->kind = $kind;
  }
  /**
   * @return string
   */
  public function getKind()
  {
    return $this->kind;
  }
  /**
   * @param string
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param string
   */
  public function setNatIP($natIP)
  {
    $this->natIP = $natIP;
  }
  /**
   * @return string
   */
  public function getNatIP()
  {
    return $this->natIP;
  }
  /**
   * @param string
   */
  public function setNetworkTier($networkTier)
  {
    $this->networkTier = $networkTier;
  }
  /**
   * @return string
   */
  public function getNetworkTier()
  {
    return $this->networkTier;
  }
  /**
   * @param string
   */
  public function setPublicPtrDomainName($publicPtrDomainName)
  {
    $this->publicPtrDomainName = $publicPtrDomainName;
  }
  /**
   * @return string
   */
  public function getPublicPtrDomainName()
  {
    return $this->publicPtrDomainName;
  }
  /**
   * @param string
   */
  public function setSecurityPolicy($securityPolicy)
  {
    $this->securityPolicy = $securityPolicy;
  }
  /**
   * @return string
   */
  public function getSecurityPolicy()
  {
    return $this->securityPolicy;
  }
  /**
   * @param bool
   */
  public function setSetPublicPtr($setPublicPtr)
  {
    $this->setPublicPtr = $setPublicPtr;
  }
  /**
   * @return bool
   */
  public function getSetPublicPtr()
  {
    return $this->setPublicPtr;
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
class_alias(AccessConfig::class, 'Google_Service_Compute_AccessConfig');
