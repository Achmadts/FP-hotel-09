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

namespace Google\Service\GoogleAnalyticsAdmin;

class GoogleAnalyticsAdminV1alphaAccessFilterExpressionList extends \Google\Collection
{
  protected $collection_key = 'expressions';
  protected $expressionsType = GoogleAnalyticsAdminV1alphaAccessFilterExpression::class;
  protected $expressionsDataType = 'array';

  /**
   * @param GoogleAnalyticsAdminV1alphaAccessFilterExpression[]
   */
  public function setExpressions($expressions)
  {
    $this->expressions = $expressions;
  }
  /**
   * @return GoogleAnalyticsAdminV1alphaAccessFilterExpression[]
   */
  public function getExpressions()
  {
    return $this->expressions;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleAnalyticsAdminV1alphaAccessFilterExpressionList::class, 'Google_Service_GoogleAnalyticsAdmin_GoogleAnalyticsAdminV1alphaAccessFilterExpressionList');
