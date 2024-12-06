<?php

namespace App\Console\Commands;

use App\Repositories\ScheduleEventRepository;
use Illuminate\Console\Command;

class ChangeScheduledEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:scheduled-event-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Scheduled Event Status';

    private $scheduleEventRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ScheduleEventRepository $scheduleEventRepository)
    {
        parent::__construct();
        $this->scheduleEventRepo = $scheduleEventRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Change Scheduled Event Status...');

        $this->scheduleEventRepo->changeStatus();

        $this->info('Change Scheduled Event Status successfully!');

        return true;
    }
}
