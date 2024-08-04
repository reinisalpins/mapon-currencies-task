<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\EuroExchangeRateRepository;
use Exception;
use Illuminate\Console\Command;

class LoadEuroExchangeRates extends Command
{
    public function __construct(
        private readonly EuroExchangeRateRepository $exchangeRateRepository
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:load {--past-week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to load exchange rates from bank.lv website';

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $pastWeekOption = $this->option('past-week');

        if ($pastWeekOption) {
            $this->exchangeRateRepository->loadAndSaveExchangeRatesForPastWeek();
        } else {
            $this->exchangeRateRepository->loadAndSaveExchangeRatesForToday();
        }

        return Command::SUCCESS;
    }
}
