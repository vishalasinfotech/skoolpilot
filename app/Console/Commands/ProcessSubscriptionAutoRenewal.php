<?php

namespace App\Console\Commands;

use App\Services\SubscriptionAutoRenewalService;
use Illuminate\Console\Command;

class ProcessSubscriptionAutoRenewal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:auto-renewal {--days=7 : Number of days before expiry to process renewals}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process automatic subscription renewals for schools with auto-renewal enabled';

    /**
     * Execute the console command.
     */
    public function handle(SubscriptionAutoRenewalService $service): int
    {
        $this->info('Processing subscription auto-renewals...');

        $daysBeforeExpiry = (int) $this->option('days');
        $results = $service->processPendingRenewals();

        $this->info("Processed: {$results['processed']}");
        $this->info("Succeeded: {$results['succeeded']}");
        $this->info("Failed: {$results['failed']}");

        if ($results['failed'] > 0) {
            $this->warn('Some renewals failed. Check the logs for details.');

            return Command::FAILURE;
        }

        $this->info('All auto-renewals processed successfully.');

        return Command::SUCCESS;
    }
}
