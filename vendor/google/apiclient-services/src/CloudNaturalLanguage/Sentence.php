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

namespace Google\Service\CloudNaturalLanguage;

class Sentence extends \Google\Model
{
  /**
   * @var Sentiment
   */
  public $sentiment;
  protected $sentimentType = Sentiment::class;
  protected $sentimentDataType = '';
  /**
   * @var TextSpan
   */
  public $text;
  protected $textType = TextSpan::class;
  protected $textDataType = '';

  /**
   * @param Sentiment
   */
  public function setSentiment(Sentiment $sentiment)
  {
    $this->sentiment = $sentiment;
  }
  /**
   * @return Sentiment
   */
  public function getSentiment()
  {
    return $this->sentiment;
  }
  /**
   * @param TextSpan
   */
  public function setText(TextSpan $text)
  {
    $this->text = $text;
  }
  /**
   * @return TextSpan
   */
  public function getText()
  {
    return $this->text;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Sentence::class, 'Google_Service_CloudNaturalLanguage_Sentence');
