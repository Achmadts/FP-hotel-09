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

class AssistantApiSettingsOnDeviceAppSettings extends \Google\Model
{
  /**
   * @var AssistantApiSettingsCarrierCallDeviceSettings
   */
  public $carrierCallDeviceSettings;
  protected $carrierCallDeviceSettingsType = AssistantApiSettingsCarrierCallDeviceSettings::class;
  protected $carrierCallDeviceSettingsDataType = '';
  /**
   * @var AssistantApiSettingsDuoCallDeviceSettings
   */
  public $duoCallDeviceSettings;
  protected $duoCallDeviceSettingsType = AssistantApiSettingsDuoCallDeviceSettings::class;
  protected $duoCallDeviceSettingsDataType = '';

  /**
   * @param AssistantApiSettingsCarrierCallDeviceSettings
   */
  public function setCarrierCallDeviceSettings(AssistantApiSettingsCarrierCallDeviceSettings $carrierCallDeviceSettings)
  {
    $this->carrierCallDeviceSettings = $carrierCallDeviceSettings;
  }
  /**
   * @return AssistantApiSettingsCarrierCallDeviceSettings
   */
  public function getCarrierCallDeviceSettings()
  {
    return $this->carrierCallDeviceSettings;
  }
  /**
   * @param AssistantApiSettingsDuoCallDeviceSettings
   */
  public function setDuoCallDeviceSettings(AssistantApiSettingsDuoCallDeviceSettings $duoCallDeviceSettings)
  {
    $this->duoCallDeviceSettings = $duoCallDeviceSettings;
  }
  /**
   * @return AssistantApiSettingsDuoCallDeviceSettings
   */
  public function getDuoCallDeviceSettings()
  {
    return $this->duoCallDeviceSettings;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AssistantApiSettingsOnDeviceAppSettings::class, 'Google_Service_Contentwarehouse_AssistantApiSettingsOnDeviceAppSettings');
