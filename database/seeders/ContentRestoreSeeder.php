<?php

namespace Database\Seeders;

use App\Models\Expert;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Service;
use App\Models\TrainingActivity;
use App\Models\TrainingBag;
use App\Models\TrainingBagSample;
use App\Models\VideoItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ContentRestoreSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        TrainingBagSample::truncate();
        if (Schema::hasTable('training_bag_cycle_steps')) {
            \App\Models\TrainingBagCycleStep::truncate();
        }
        TrainingBag::truncate();
        TrainingActivity::truncate();
        VideoItem::truncate();
        Publication::truncate();
        \DB::table('expert_project')->truncate();
        Project::truncate();
        Partner::truncate();
        Expert::truncate();
        Service::truncate();

        Schema::enableForeignKeyConstraints();

        $seeder = new DatabaseSeeder;
        $seeder->seedServices();
        $seeder->seedExperts();
        $seeder->seedPartners();
        $seeder->seedProjects();
        $seeder->seedTrainingBags();
        $seeder->seedActivities();
        $seeder->seedVideos();
        $seeder->seedPublications();
    }
}
