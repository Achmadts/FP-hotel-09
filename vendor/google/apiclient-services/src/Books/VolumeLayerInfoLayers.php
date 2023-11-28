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

namespace Google\Service\Books;

class VolumeLayerInfoLayers extends \Google\Model
{
  /**
   * @var string
   */
  public $layerId;
  /**
   * @var string
   */
  public $volumeAnnotationsVersion;

  /**
   * @param string
   */
  public function setLayerId($layerId)
  {
    $this->layerId = $layerId;
  }
  /**
   * @return string
   */
  public function getLayerId()
  {
    return $this->layerId;
  }
  /**
   * @param string
   */
  public function setVolumeAnnotationsVersion($volumeAnnotationsVersion)
  {
    $this->volumeAnnotationsVersion = $volumeAnnotationsVersion;
  }
  /**
   * @return string
   */
  public function getVolumeAnnotationsVersion()
  {
    return $this->volumeAnnotationsVersion;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(VolumeLayerInfoLayers::class, 'Google_Service_Books_VolumeLayerInfoLayers');
