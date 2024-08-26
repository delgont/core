<?php

use Illuminate\Database\Seeder;

use App\Models\Coa;

use App\Option;
use App\Models\Department\Department;
use App\Models\Accounts\AccountingPeriod;


class DatabaseSeeder extends Seeder
{

    protected $departments = [
        'IT Department', 'Science', 'Arts', 'Accounts', 'Games & Sports'
    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->settings();

        $this->call(TermSeeder::class);
        $this->call(ClazzSeeder::class);
        $this->call(HostelSeeder::class);
        
        $this->call(BuildingSeeder::class);

        //$this->call(FeeSeeder::class);
        //$this->call(StudentSeeder::class);

        $this->call(VendorSeeder::class);

        $this->call(GroupSeeder::class);
        $this->call(StaffSeeder::class);
        //$this->call(AssetSeeder::class);

        
        $this->call(RequirementsSeeder::class);
        $this->call(AcademicSeeder::class);
        //$this->call(InventorySeeder::class);

    }

    public function settings()
    {

        $accountPeriod = AccountingPeriod::updateOrCreate(['name' => '2023-2024'],[
            'name' => '2023-2024',
            'start_date' => '2023-07-01',
            'end_date' => '2024-07-01'
        ]);

       
    }
}

