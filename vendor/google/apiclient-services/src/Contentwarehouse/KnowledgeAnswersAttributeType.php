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

class KnowledgeAnswersAttributeType extends \Google\Collection
{
  protected $collection_key = 'attribute';
  /**
   * @var string[]
   */
  public $attribute;
  /**
   * @var NlpMeaningComponentSpecificContracts
   */
  public $componentSpecificContracts;
  protected $componentSpecificContractsType = NlpMeaningComponentSpecificContracts::class;
  protected $componentSpecificContractsDataType = '';
  /**
   * @var string
   */
  public $pivotEntitySlot;
  /**
   * @var NlpMeaningMeaningRemodelings
   */
  public $remodelings;
  protected $remodelingsType = NlpMeaningMeaningRemodelings::class;
  protected $remodelingsDataType = '';

  /**
   * @param string[]
   */
  public function setAttribute($attribute)
  {
    $this->attribute = $attribute;
  }
  /**
   * @return string[]
   */
  public function getAttribute()
  {
    return $this->attribute;
  }
  /**
   * @param NlpMeaningComponentSpecificContracts
   */
  public function setComponentSpecificContracts(NlpMeaningComponentSpecificContracts $componentSpecificContracts)
  {
    $this->componentSpecificContracts = $componentSpecificContracts;
  }
  /**
   * @return NlpMeaningComponentSpecificContracts
   */
  public function getComponentSpecificContracts()
  {
    return $this->componentSpecificContracts;
  }
  /**
   * @param string
   */
  public function setPivotEntitySlot($pivotEntitySlot)
  {
    $this->pivotEntitySlot = $pivotEntitySlot;
  }
  /**
   * @return string
   */
  public function getPivotEntitySlot()
  {
    return $this->pivotEntitySlot;
  }
  /**
   * @param NlpMeaningMeaningRemodelings
   */
  public function setRemodelings(NlpMeaningMeaningRemodelings $remodelings)
  {
    $this->remodelings = $remodelings;
  }
  /**
   * @return NlpMeaningMeaningRemodelings
   */
  public function getRemodelings()
  {
    return $this->remodelings;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(KnowledgeAnswersAttributeType::class, 'Google_Service_Contentwarehouse_KnowledgeAnswersAttributeType');
