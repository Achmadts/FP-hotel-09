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

namespace Google\Service\Apigee;

class GoogleCloudApigeeV1App extends \Google\Collection
{
  protected $collection_key = 'scopes';
  protected $apiProductsType = GoogleCloudApigeeV1ApiProductRef::class;
  protected $apiProductsDataType = 'array';
  /**
   * @var string
   */
  public $appGroup;
  /**
   * @var string
   */
  public $appId;
  protected $attributesType = GoogleCloudApigeeV1Attribute::class;
  protected $attributesDataType = 'array';
  /**
   * @var string
   */
  public $callbackUrl;
  /**
   * @var string
   */
  public $companyName;
  /**
   * @var string
   */
  public $createdAt;
  protected $credentialsType = GoogleCloudApigeeV1Credential::class;
  protected $credentialsDataType = 'array';
  /**
   * @var string
   */
  public $developerEmail;
  /**
   * @var string
   */
  public $developerId;
  /**
   * @var string
   */
  public $keyExpiresIn;
  /**
   * @var string
   */
  public $lastModifiedAt;
  /**
   * @var string
   */
  public $name;
  /**
   * @var string[]
   */
  public $scopes;
  /**
   * @var string
   */
  public $status;

  /**
   * @param GoogleCloudApigeeV1ApiProductRef[]
   */
  public function setApiProducts($apiProducts)
  {
    $this->apiProducts = $apiProducts;
  }
  /**
   * @return GoogleCloudApigeeV1ApiProductRef[]
   */
  public function getApiProducts()
  {
    return $this->apiProducts;
  }
  /**
   * @param string
   */
  public function setAppGroup($appGroup)
  {
    $this->appGroup = $appGroup;
  }
  /**
   * @return string
   */
  public function getAppGroup()
  {
    return $this->appGroup;
  }
  /**
   * @param string
   */
  public function setAppId($appId)
  {
    $this->appId = $appId;
  }
  /**
   * @return string
   */
  public function getAppId()
  {
    return $this->appId;
  }
  /**
   * @param GoogleCloudApigeeV1Attribute[]
   */
  public function setAttributes($attributes)
  {
    $this->attributes = $attributes;
  }
  /**
   * @return GoogleCloudApigeeV1Attribute[]
   */
  public function getAttributes()
  {
    return $this->attributes;
  }
  /**
   * @param string
   */
  public function setCallbackUrl($callbackUrl)
  {
    $this->callbackUrl = $callbackUrl;
  }
  /**
   * @return string
   */
  public function getCallbackUrl()
  {
    return $this->callbackUrl;
  }
  /**
   * @param string
   */
  public function setCompanyName($companyName)
  {
    $this->companyName = $companyName;
  }
  /**
   * @return string
   */
  public function getCompanyName()
  {
    return $this->companyName;
  }
  /**
   * @param string
   */
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }
  /**
   * @return string
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }
  /**
   * @param GoogleCloudApigeeV1Credential[]
   */
  public function setCredentials($credentials)
  {
    $this->credentials = $credentials;
  }
  /**
   * @return GoogleCloudApigeeV1Credential[]
   */
  public function getCredentials()
  {
    return $this->credentials;
  }
  /**
   * @param string
   */
  public function setDeveloperEmail($developerEmail)
  {
    $this->developerEmail = $developerEmail;
  }
  /**
   * @return string
   */
  public function getDeveloperEmail()
  {
    return $this->developerEmail;
  }
  /**
   * @param string
   */
  public function setDeveloperId($developerId)
  {
    $this->developerId = $developerId;
  }
  /**
   * @return string
   */
  public function getDeveloperId()
  {
    return $this->developerId;
  }
  /**
   * @param string
   */
  public function setKeyExpiresIn($keyExpiresIn)
  {
    $this->keyExpiresIn = $keyExpiresIn;
  }
  /**
   * @return string
   */
  public function getKeyExpiresIn()
  {
    return $this->keyExpiresIn;
  }
  /**
   * @param string
   */
  public function setLastModifiedAt($lastModifiedAt)
  {
    $this->lastModifiedAt = $lastModifiedAt;
  }
  /**
   * @return string
   */
  public function getLastModifiedAt()
  {
    return $this->lastModifiedAt;
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
   * @param string[]
   */
  public function setScopes($scopes)
  {
    $this->scopes = $scopes;
  }
  /**
   * @return string[]
   */
  public function getScopes()
  {
    return $this->scopes;
  }
  /**
   * @param string
   */
  public function setStatus($status)
  {
    $this->status = $status;
  }
  /**
   * @return string
   */
  public function getStatus()
  {
    return $this->status;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudApigeeV1App::class, 'Google_Service_Apigee_GoogleCloudApigeeV1App');
