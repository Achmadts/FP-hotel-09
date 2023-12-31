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

namespace Google\Service\YouTube;

class ThirdPartyLink extends \Google\Model
{
  /**
   * @var string
   */
  public $etag;
  /**
   * @var string
   */
  public $kind;
  /**
   * @var string
   */
  public $linkingToken;
  /**
   * @var ThirdPartyLinkSnippet
   */
  public $snippet;
  protected $snippetType = ThirdPartyLinkSnippet::class;
  protected $snippetDataType = '';
  /**
   * @var ThirdPartyLinkStatus
   */
  public $status;
  protected $statusType = ThirdPartyLinkStatus::class;
  protected $statusDataType = '';

  /**
   * @param string
   */
  public function setEtag($etag)
  {
    $this->etag = $etag;
  }
  /**
   * @return string
   */
  public function getEtag()
  {
    return $this->etag;
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
  public function setLinkingToken($linkingToken)
  {
    $this->linkingToken = $linkingToken;
  }
  /**
   * @return string
   */
  public function getLinkingToken()
  {
    return $this->linkingToken;
  }
  /**
   * @param ThirdPartyLinkSnippet
   */
  public function setSnippet(ThirdPartyLinkSnippet $snippet)
  {
    $this->snippet = $snippet;
  }
  /**
   * @return ThirdPartyLinkSnippet
   */
  public function getSnippet()
  {
    return $this->snippet;
  }
  /**
   * @param ThirdPartyLinkStatus
   */
  public function setStatus(ThirdPartyLinkStatus $status)
  {
    $this->status = $status;
  }
  /**
   * @return ThirdPartyLinkStatus
   */
  public function getStatus()
  {
    return $this->status;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ThirdPartyLink::class, 'Google_Service_YouTube_ThirdPartyLink');
