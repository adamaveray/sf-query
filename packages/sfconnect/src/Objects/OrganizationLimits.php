<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

/**
 * @property-read string $AnalyticsExternalDataSizeMB
 * @property-read string $ConcurrentAsyncGetReportInstances
 * @property-read string $ConcurrentSyncReportRuns
 * @property-read string $HourlyAsyncReportRuns
 * @property-read string $HourlySyncReportRuns
 * @property-read string $HourlyDashboardRefreshes
 * @property-read string $HourlyDashboardResults
 * @property-read string $HourlyDashboardStatuses
 * @property-read string $MassEmail
 * @property-read string $SingleEmail
 * @property-read string $Lightning
 * @property-read string $DailyApiRequests
 * @property-read string $DailyAsyncApexExecutions
 * @property-read string $DailyAsyncApexTests
 * @property-read string $DailyBulkApiRequests
 * @property-read string $DailyBulkV2QueryFileStorageMB
 * @property-read string $DailyBulkV2QueryJobs
 * @property-read string $HourlyPublishedPlatformEvents
 * @property-read string $HourlyPublishedStandardVolumePlatform
 * @property-read string $DailyStandardVolumePlatformEvents
 * @property-read string $DailyDeliveredPlatformEvents
 * @property-read string $MonthlyPlatformEvents
 * @property-read string $MonthlyPlatformEventsUsageEntitlement
 * @property-read string $PrivateConnectOutboundCalloutHourlyLimitMB
 * @property-read string $HourlyLongTermIdMapping
 * @property-read string $HourlyODataCallout
 * @property-read string $HourlyShortTermIdMapping
 * @property-read string $ActiveScratchOrgs
 * @property-read string $DailyScratchOrgs
 * @property-read string $Package2VersionCreates
 * @property-read string $Package2VersionCreatesWithoutValidation
 * @property-read string $DailyFunctionsApiCallLimit
 * @property-read string $DataStorageMB
 * @property-read string $FileStorageMB
 * @property-read string $DailyDurableGenericStreamingApiEvents
 * @property-read string $DailyDurableStreamingApiEvents
 * @property-read string $DurableStreamingApiConcurrentClients
 * @property-read string $DailyGenericStreamingApiEvents
 * @property-read string $DailyStreamingApiEvents
 * @property-read string $StreamingApiConcurrentClients
 * @property-read string $DailyWorkflowEmails
 * @property-read string $HourlyTimeBasedWorkflow
 */
final readonly class OrganizationLimits
{
  use ObjectAccessTrait;
}
