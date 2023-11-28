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

namespace Google\Service\CloudAlloyDBAdmin;

class ContinuousBackupSource extends \Google\Model
{
  /**
   * @var string
   */
  public $cluster;
  /**
   * @var string
   */
  public $pointInTime;

  /**
   * @param string
   */
  public function setCluster($cluster)
  {
    $this->cluster = $cluster;
  }
  /**
   * @return string
   */
  public function getCluster()
  {
    return $this->cluster;
  }
  /**
   * @param string
   */
  public function setPointInTime($pointInTime)
  {
    $this->pointInTime = $pointInTime;
  }
  /**
   * @return string
   */
  public function getPointInTime()
  {
    return $this->pointInTime;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ContinuousBackupSource::class, 'Google_Service_CloudAlloyDBAdmin_ContinuousBackupSource');
