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

namespace Google\Service\Dialogflow;

class GoogleCloudDialogflowCxV3beta1FormParameterFillBehavior extends \Google\Collection
{
  protected $collection_key = 'repromptEventHandlers';
  /**
   * @var GoogleCloudDialogflowCxV3beta1Fulfillment
   */
  public $initialPromptFulfillment;
  protected $initialPromptFulfillmentType = GoogleCloudDialogflowCxV3beta1Fulfillment::class;
  protected $initialPromptFulfillmentDataType = '';
  /**
   * @var GoogleCloudDialogflowCxV3beta1EventHandler[]
   */
  public $repromptEventHandlers;
  protected $repromptEventHandlersType = GoogleCloudDialogflowCxV3beta1EventHandler::class;
  protected $repromptEventHandlersDataType = 'array';

  /**
   * @param GoogleCloudDialogflowCxV3beta1Fulfillment
   */
  public function setInitialPromptFulfillment(GoogleCloudDialogflowCxV3beta1Fulfillment $initialPromptFulfillment)
  {
    $this->initialPromptFulfillment = $initialPromptFulfillment;
  }
  /**
   * @return GoogleCloudDialogflowCxV3beta1Fulfillment
   */
  public function getInitialPromptFulfillment()
  {
    return $this->initialPromptFulfillment;
  }
  /**
   * @param GoogleCloudDialogflowCxV3beta1EventHandler[]
   */
  public function setRepromptEventHandlers($repromptEventHandlers)
  {
    $this->repromptEventHandlers = $repromptEventHandlers;
  }
  /**
   * @return GoogleCloudDialogflowCxV3beta1EventHandler[]
   */
  public function getRepromptEventHandlers()
  {
    return $this->repromptEventHandlers;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudDialogflowCxV3beta1FormParameterFillBehavior::class, 'Google_Service_Dialogflow_GoogleCloudDialogflowCxV3beta1FormParameterFillBehavior');
