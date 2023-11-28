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

namespace Google\Service\DiscoveryEngine;

class GoogleCloudDiscoveryengineV1alphaControl extends \Google\Collection
{
  protected $collection_key = 'useCases';
  /**
   * @var string[]
   */
  public $associatedServingConfigIds = [];
  protected $boostActionType = GoogleCloudDiscoveryengineV1alphaControlBoostAction::class;
  protected $boostActionDataType = '';
  public $boostAction;
  protected $conditionsType = GoogleCloudDiscoveryengineV1alphaCondition::class;
  protected $conditionsDataType = 'array';
  public $conditions = [];
  /**
   * @var string
   */
  public $displayName;
  protected $filterActionType = GoogleCloudDiscoveryengineV1alphaControlFilterAction::class;
  protected $filterActionDataType = '';
  public $filterAction;
  /**
   * @var string
   */
  public $name;
  /**
   * @var string
   */
  public $solutionType;
  /**
   * @var string[]
   */
  public $useCases = [];

  /**
   * @param string[]
   */
  public function setAssociatedServingConfigIds($associatedServingConfigIds)
  {
    $this->associatedServingConfigIds = $associatedServingConfigIds;
  }
  /**
   * @return string[]
   */
  public function getAssociatedServingConfigIds()
  {
    return $this->associatedServingConfigIds;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1alphaControlBoostAction
   */
  public function setBoostAction(GoogleCloudDiscoveryengineV1alphaControlBoostAction $boostAction)
  {
    $this->boostAction = $boostAction;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1alphaControlBoostAction
   */
  public function getBoostAction()
  {
    return $this->boostAction;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1alphaCondition[]
   */
  public function setConditions($conditions)
  {
    $this->conditions = $conditions;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1alphaCondition[]
   */
  public function getConditions()
  {
    return $this->conditions;
  }
  /**
   * @param string
   */
  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }
  /**
   * @return string
   */
  public function getDisplayName()
  {
    return $this->displayName;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1alphaControlFilterAction
   */
  public function setFilterAction(GoogleCloudDiscoveryengineV1alphaControlFilterAction $filterAction)
  {
    $this->filterAction = $filterAction;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1alphaControlFilterAction
   */
  public function getFilterAction()
  {
    return $this->filterAction;
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
  public function setSolutionType($solutionType)
  {
    $this->solutionType = $solutionType;
  }
  /**
   * @return string
   */
  public function getSolutionType()
  {
    return $this->solutionType;
  }
  /**
   * @param string[]
   */
  public function setUseCases($useCases)
  {
    $this->useCases = $useCases;
  }
  /**
   * @return string[]
   */
  public function getUseCases()
  {
    return $this->useCases;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudDiscoveryengineV1alphaControl::class, 'Google_Service_DiscoveryEngine_GoogleCloudDiscoveryengineV1alphaControl');
