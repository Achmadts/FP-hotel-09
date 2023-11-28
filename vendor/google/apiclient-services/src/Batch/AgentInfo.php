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

namespace Google\Service\Batch;

class AgentInfo extends \Google\Collection
{
  protected $collection_key = 'tasks';
  /**
   * @var string
   */
  public $jobId;
  /**
   * @var string
   */
  public $reportTime;
  /**
   * @var string
   */
  public $state;
  /**
   * @var string
   */
  public $taskGroupId;
  protected $tasksType = AgentTaskInfo::class;
  protected $tasksDataType = 'array';

  /**
   * @param string
   */
  public function setJobId($jobId)
  {
    $this->jobId = $jobId;
  }
  /**
   * @return string
   */
  public function getJobId()
  {
    return $this->jobId;
  }
  /**
   * @param string
   */
  public function setReportTime($reportTime)
  {
    $this->reportTime = $reportTime;
  }
  /**
   * @return string
   */
  public function getReportTime()
  {
    return $this->reportTime;
  }
  /**
   * @param string
   */
  public function setState($state)
  {
    $this->state = $state;
  }
  /**
   * @return string
   */
  public function getState()
  {
    return $this->state;
  }
  /**
   * @param string
   */
  public function setTaskGroupId($taskGroupId)
  {
    $this->taskGroupId = $taskGroupId;
  }
  /**
   * @return string
   */
  public function getTaskGroupId()
  {
    return $this->taskGroupId;
  }
  /**
   * @param AgentTaskInfo[]
   */
  public function setTasks($tasks)
  {
    $this->tasks = $tasks;
  }
  /**
   * @return AgentTaskInfo[]
   */
  public function getTasks()
  {
    return $this->tasks;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AgentInfo::class, 'Google_Service_Batch_AgentInfo');
