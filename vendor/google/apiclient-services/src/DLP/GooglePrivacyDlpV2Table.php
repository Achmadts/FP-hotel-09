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

namespace Google\Service\DLP;

class GooglePrivacyDlpV2Table extends \Google\Collection
{
  protected $collection_key = 'rows';
  /**
   * @var GooglePrivacyDlpV2FieldId[]
   */
  public $headers;
  protected $headersType = GooglePrivacyDlpV2FieldId::class;
  protected $headersDataType = 'array';
  /**
   * @var GooglePrivacyDlpV2Row[]
   */
  public $rows;
  protected $rowsType = GooglePrivacyDlpV2Row::class;
  protected $rowsDataType = 'array';

  /**
   * @param GooglePrivacyDlpV2FieldId[]
   */
  public function setHeaders($headers)
  {
    $this->headers = $headers;
  }
  /**
   * @return GooglePrivacyDlpV2FieldId[]
   */
  public function getHeaders()
  {
    return $this->headers;
  }
  /**
   * @param GooglePrivacyDlpV2Row[]
   */
  public function setRows($rows)
  {
    $this->rows = $rows;
  }
  /**
   * @return GooglePrivacyDlpV2Row[]
   */
  public function getRows()
  {
    return $this->rows;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GooglePrivacyDlpV2Table::class, 'Google_Service_DLP_GooglePrivacyDlpV2Table');
