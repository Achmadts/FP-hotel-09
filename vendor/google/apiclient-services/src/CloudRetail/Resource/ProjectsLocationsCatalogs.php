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

namespace Google\Service\CloudRetail\Resource;

use Google\Service\CloudRetail\GoogleCloudRetailV2AttributesConfig;
use Google\Service\CloudRetail\GoogleCloudRetailV2Catalog;
use Google\Service\CloudRetail\GoogleCloudRetailV2CompleteQueryResponse;
use Google\Service\CloudRetail\GoogleCloudRetailV2CompletionConfig;
use Google\Service\CloudRetail\GoogleCloudRetailV2GetDefaultBranchResponse;
use Google\Service\CloudRetail\GoogleCloudRetailV2ListCatalogsResponse;
use Google\Service\CloudRetail\GoogleCloudRetailV2SetDefaultBranchRequest;
use Google\Service\CloudRetail\GoogleProtobufEmpty;

/**
 * The "catalogs" collection of methods.
 * Typical usage is:
 *  <code>
 *   $retailService = new Google\Service\CloudRetail(...);
 *   $catalogs = $retailService->projects_locations_catalogs;
 *  </code>
 */
class ProjectsLocationsCatalogs extends \Google\Service\Resource
{
  /**
   * Completes the specified prefix with keyword suggestions. This feature is only
   * available for users who have Retail Search enabled. Enable Retail Search on
   * Cloud Console before using this feature. (catalogs.completeQuery)
   *
   * @param string $catalog Required. Catalog for which the completion is
   * performed. Full resource name of catalog, such as
   * `projects/locations/global/catalogs/default_catalog`.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string dataset Determines which dataset to use for fetching
   * completion. "user-data" will use the imported dataset through
   * CompletionService.ImportCompletionData. "cloud-retail" will use the dataset
   * generated by cloud retail based on user events. If leave empty, it will use
   * the "user-data". Current supported values: * user-data * cloud-retail: This
   * option requires enabling auto-learning function first. See
   * [guidelines](https://cloud.google.com/retail/docs/completion-
   * overview#generated-completion-dataset).
   * @opt_param string deviceType The device type context for completion
   * suggestions. We recommend that you leave this field empty. It can apply
   * different suggestions on different device types, e.g. `DESKTOP`, `MOBILE`. If
   * it is empty, the suggestions are across all device types. Supported formats:
   * * `UNKNOWN_DEVICE_TYPE` * `DESKTOP` * `MOBILE` * A customized string starts
   * with `OTHER_`, e.g. `OTHER_IPHONE`.
   * @opt_param string entity The entity for customers who run multiple entities,
   * domains, sites, or regions, for example, `Google US`, `Google Ads`, `Waymo`,
   * `google.com`, `youtube.com`, etc. If this is set, it must be an exact match
   * with UserEvent.entity to get per-entity autocomplete results.
   * @opt_param string languageCodes Note that this field applies for `user-data`
   * dataset only. For requests with `cloud-retail` dataset, setting this field
   * has no effect. The language filters applied to the output suggestions. If
   * set, it should contain the language of the query. If not set, suggestions are
   * returned without considering language restrictions. This is the BCP-47
   * language code, such as "en-US" or "sr-Latn". For more information, see [Tags
   * for Identifying Languages](https://tools.ietf.org/html/bcp47). The maximum
   * number of language codes is 3.
   * @opt_param int maxSuggestions Completion max suggestions. If left unset or
   * set to 0, then will fallback to the configured value
   * CompletionConfig.max_suggestions. The maximum allowed max suggestions is 20.
   * If it is set higher, it will be capped by 20.
   * @opt_param string query Required. The query used to generate suggestions. The
   * maximum number of allowed characters is 255.
   * @opt_param string visitorId Required field. A unique identifier for tracking
   * visitors. For example, this could be implemented with an HTTP cookie, which
   * should be able to uniquely identify a visitor on a single device. This unique
   * identifier should not change if the visitor logs in or out of the website.
   * The field must be a UTF-8 encoded string with a length limit of 128
   * characters. Otherwise, an INVALID_ARGUMENT error is returned.
   * @return GoogleCloudRetailV2CompleteQueryResponse
   */
  public function completeQuery($catalog, $optParams = [])
  {
    $params = ['catalog' => $catalog];
    $params = array_merge($params, $optParams);
    return $this->call('completeQuery', [$params], GoogleCloudRetailV2CompleteQueryResponse::class);
  }
  /**
   * Gets an AttributesConfig. (catalogs.getAttributesConfig)
   *
   * @param string $name Required. Full AttributesConfig resource name. Format: `p
   * rojects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/attrib
   * utesConfig`
   * @param array $optParams Optional parameters.
   * @return GoogleCloudRetailV2AttributesConfig
   */
  public function getAttributesConfig($name, $optParams = [])
  {
    $params = ['name' => $name];
    $params = array_merge($params, $optParams);
    return $this->call('getAttributesConfig', [$params], GoogleCloudRetailV2AttributesConfig::class);
  }
  /**
   * Gets a CompletionConfig. (catalogs.getCompletionConfig)
   *
   * @param string $name Required. Full CompletionConfig resource name. Format: `p
   * rojects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/comple
   * tionConfig`
   * @param array $optParams Optional parameters.
   * @return GoogleCloudRetailV2CompletionConfig
   */
  public function getCompletionConfig($name, $optParams = [])
  {
    $params = ['name' => $name];
    $params = array_merge($params, $optParams);
    return $this->call('getCompletionConfig', [$params], GoogleCloudRetailV2CompletionConfig::class);
  }
  /**
   * Get which branch is currently default branch set by
   * CatalogService.SetDefaultBranch method under a specified parent catalog.
   * (catalogs.getDefaultBranch)
   *
   * @param string $catalog The parent catalog resource name, such as
   * `projects/locations/global/catalogs/default_catalog`.
   * @param array $optParams Optional parameters.
   * @return GoogleCloudRetailV2GetDefaultBranchResponse
   */
  public function getDefaultBranch($catalog, $optParams = [])
  {
    $params = ['catalog' => $catalog];
    $params = array_merge($params, $optParams);
    return $this->call('getDefaultBranch', [$params], GoogleCloudRetailV2GetDefaultBranchResponse::class);
  }
  /**
   * Lists all the Catalogs associated with the project.
   * (catalogs.listProjectsLocationsCatalogs)
   *
   * @param string $parent Required. The account resource name with an associated
   * location. If the caller does not have permission to list Catalogs under this
   * location, regardless of whether or not this location exists, a
   * PERMISSION_DENIED error is returned.
   * @param array $optParams Optional parameters.
   *
   * @opt_param int pageSize Maximum number of Catalogs to return. If unspecified,
   * defaults to 50. The maximum allowed value is 1000. Values above 1000 will be
   * coerced to 1000. If this field is negative, an INVALID_ARGUMENT is returned.
   * @opt_param string pageToken A page token
   * ListCatalogsResponse.next_page_token, received from a previous
   * CatalogService.ListCatalogs call. Provide this to retrieve the subsequent
   * page. When paginating, all other parameters provided to
   * CatalogService.ListCatalogs must match the call that provided the page token.
   * Otherwise, an INVALID_ARGUMENT error is returned.
   * @return GoogleCloudRetailV2ListCatalogsResponse
   */
  public function listProjectsLocationsCatalogs($parent, $optParams = [])
  {
    $params = ['parent' => $parent];
    $params = array_merge($params, $optParams);
    return $this->call('list', [$params], GoogleCloudRetailV2ListCatalogsResponse::class);
  }
  /**
   * Updates the Catalogs. (catalogs.patch)
   *
   * @param string $name Required. Immutable. The fully qualified resource name of
   * the catalog.
   * @param GoogleCloudRetailV2Catalog $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string updateMask Indicates which fields in the provided Catalog
   * to update. If an unsupported or unknown field is provided, an
   * INVALID_ARGUMENT error is returned.
   * @return GoogleCloudRetailV2Catalog
   */
  public function patch($name, GoogleCloudRetailV2Catalog $postBody, $optParams = [])
  {
    $params = ['name' => $name, 'postBody' => $postBody];
    $params = array_merge($params, $optParams);
    return $this->call('patch', [$params], GoogleCloudRetailV2Catalog::class);
  }
  /**
   * Set a specified branch id as default branch. API methods such as
   * SearchService.Search, ProductService.GetProduct, ProductService.ListProducts
   * will treat requests using "default_branch" to the actual branch id set as
   * default. For example, if `projects/locations/catalogs/branches/1` is set as
   * default, setting SearchRequest.branch to
   * `projects/locations/catalogs/branches/default_branch` is equivalent to
   * setting SearchRequest.branch to `projects/locations/catalogs/branches/1`.
   * Using multiple branches can be useful when developers would like to have a
   * staging branch to test and verify for future usage. When it becomes ready,
   * developers switch on the staging branch using this API while keeping using
   * `projects/locations/catalogs/branches/default_branch` as SearchRequest.branch
   * to route the traffic to this staging branch. CAUTION: If you have live
   * predict/search traffic, switching the default branch could potentially cause
   * outages if the ID space of the new branch is very different from the old one.
   * More specifically: * PredictionService will only return product IDs from
   * branch {newBranch}. * SearchService will only return product IDs from branch
   * {newBranch} (if branch is not explicitly set). * UserEventService will only
   * join events with products from branch {newBranch}.
   * (catalogs.setDefaultBranch)
   *
   * @param string $catalog Full resource name of the catalog, such as
   * `projects/locations/global/catalogs/default_catalog`.
   * @param GoogleCloudRetailV2SetDefaultBranchRequest $postBody
   * @param array $optParams Optional parameters.
   * @return GoogleProtobufEmpty
   */
  public function setDefaultBranch($catalog, GoogleCloudRetailV2SetDefaultBranchRequest $postBody, $optParams = [])
  {
    $params = ['catalog' => $catalog, 'postBody' => $postBody];
    $params = array_merge($params, $optParams);
    return $this->call('setDefaultBranch', [$params], GoogleProtobufEmpty::class);
  }
  /**
   * Updates the AttributesConfig. The catalog attributes in the request will be
   * updated in the catalog, or inserted if they do not exist. Existing catalog
   * attributes not included in the request will remain unchanged. Attributes that
   * are assigned to products, but do not exist at the catalog level, are always
   * included in the response. The product attribute is assigned default values
   * for missing catalog attribute fields, e.g., searchable and dynamic facetable
   * options. (catalogs.updateAttributesConfig)
   *
   * @param string $name Required. Immutable. The fully qualified resource name of
   * the attribute config. Format: `projects/locations/catalogs/attributesConfig`
   * @param GoogleCloudRetailV2AttributesConfig $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string updateMask Indicates which fields in the provided
   * AttributesConfig to update. The following is the only supported field: *
   * AttributesConfig.catalog_attributes If not set, all supported fields are
   * updated.
   * @return GoogleCloudRetailV2AttributesConfig
   */
  public function updateAttributesConfig($name, GoogleCloudRetailV2AttributesConfig $postBody, $optParams = [])
  {
    $params = ['name' => $name, 'postBody' => $postBody];
    $params = array_merge($params, $optParams);
    return $this->call('updateAttributesConfig', [$params], GoogleCloudRetailV2AttributesConfig::class);
  }
  /**
   * Updates the CompletionConfigs. (catalogs.updateCompletionConfig)
   *
   * @param string $name Required. Immutable. Fully qualified name
   * `projects/locations/catalogs/completionConfig`
   * @param GoogleCloudRetailV2CompletionConfig $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string updateMask Indicates which fields in the provided
   * CompletionConfig to update. The following are the only supported fields: *
   * CompletionConfig.matching_order * CompletionConfig.max_suggestions *
   * CompletionConfig.min_prefix_length * CompletionConfig.auto_learning If not
   * set, all supported fields are updated.
   * @return GoogleCloudRetailV2CompletionConfig
   */
  public function updateCompletionConfig($name, GoogleCloudRetailV2CompletionConfig $postBody, $optParams = [])
  {
    $params = ['name' => $name, 'postBody' => $postBody];
    $params = array_merge($params, $optParams);
    return $this->call('updateCompletionConfig', [$params], GoogleCloudRetailV2CompletionConfig::class);
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ProjectsLocationsCatalogs::class, 'Google_Service_CloudRetail_Resource_ProjectsLocationsCatalogs');
