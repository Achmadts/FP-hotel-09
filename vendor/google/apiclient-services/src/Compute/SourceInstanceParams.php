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

class SourceInstanceParams extends \Google\Collection
{
  protected $collection_key = 'diskConfigs';
  /**
   * @var DiskInstantiationConfig[]
   */
  public $diskConfigs;
  protected $diskConfigsType = DiskInstantiationConfig::class;
  protected $diskConfigsDataType = 'array';

  /**
   * @param DiskInstantiationConfig[]
   */
  public function setDiskConfigs($diskConfigs)
  {
    $this->diskConfigs = $diskConfigs;
  }
  /**
   * @return DiskInstantiationConfig[]
   */
  public function getDiskConfigs()
  {
    return $this->diskConfigs;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(SourceInstanceParams::class, 'Google_Service_Compute_SourceInstanceParams');
