<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Account;
use App\Models\FundSource;
use App\Models\Transaction;
use App\Models\Lot;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = ['super_admin', 'PMU', 'MoF', 'District PIU', 'Auditor'];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        
        $user->assignRole('super_admin');

        // Create bilingual Chart of Accounts (stored as JSON)
        $accounts = [
            ['code' => '1000', 'name' => ['en' => 'Cash on Hand', 'lo' => 'ງົບເງິນສົດ'], 'type' => 'Asset', 'description' => 'Local currency cash'],
            ['code' => '1100', 'name' => ['en' => 'Bank Account – LAK', 'lo' => 'ບັນຊີທະນາຄານ (ກີບ)'], 'type' => 'Asset', 'description' => 'Main project bank account in LAK'],
            ['code' => '1200', 'name' => ['en' => 'Bank Account – USD', 'lo' => 'ບັນຊີທະນາຄານ (ໂດລາ)'], 'type' => 'Asset', 'description' => 'Donor fund holding in USD'],
            ['code' => '1300', 'name' => ['en' => 'Fund Source – Loan 4533', 'lo' => 'ກອງທຶນ ສິນເຊື່ອ 4533'], 'type' => 'Equity/Fund', 'description' => 'Balance USD 1,000,000'],
            ['code' => '1310', 'name' => ['en' => 'Fund Source – Grant 0990', 'lo' => 'ກອງທຶນ ທຶນສະໜັບສະໜູນ 0990'], 'type' => 'Equity/Fund', 'description' => 'Balance USD 500,000'],
            ['code' => '1320', 'name' => ['en' => 'Fund Source – Grant 0991', 'lo' => 'ກອງທຶນ ທຶນສະໜັບສະໜູນ 0991'], 'type' => 'Equity/Fund', 'description' => 'Balance USD 500,000'],
            ['code' => '2000', 'name' => ['en' => 'Lot Register', 'lo' => 'ລາຍການລັອດ'], 'type' => 'Control', 'description' => 'Tracks exchange rate lots (e.g., Q1 2026, 22,000 LAK/USD)'],
            ['code' => '2100', 'name' => ['en' => 'Lot Consumption – Loan 4533', 'lo' => 'ການໃຊ້ລັອດ ສິນເຊື່ອ 4533'], 'type' => 'Control', 'description' => 'FIFO consumption of Loan lots'],
            ['code' => '2110', 'name' => ['en' => 'Lot Consumption – Grant 0990', 'lo' => 'ການໃຊ້ລັອດ ທຶນ 0990'], 'type' => 'Control', 'description' => 'FIFO consumption of Grant 0990 lots'],
            ['code' => '2120', 'name' => ['en' => 'Lot Consumption – Grant 0991', 'lo' => 'ການໃຊ້ລັອດ ທຶນ 0991'], 'type' => 'Control', 'description' => 'FIFO consumption of Grant 0991 lots'],
            ['code' => '3000', 'name' => ['en' => 'Revenue – Donor A (Loan 4533)', 'lo' => 'ລາຍຮັບ ສິນເຊື່ອ 4533'], 'type' => 'Income', 'description' => 'Recognized donor inflows'],
            ['code' => '3100', 'name' => ['en' => 'Revenue – Donor B (Grant 0990)', 'lo' => 'ລາຍຮັບ ທຶນ 0990'], 'type' => 'Income', 'description' => 'Recognized donor inflows'],
            ['code' => '3200', 'name' => ['en' => 'Revenue – Donor C (Grant 0991)', 'lo' => 'ລາຍຮັບ ທຶນ 0991'], 'type' => 'Income', 'description' => 'Recognized donor inflows'],
            ['code' => '4000', 'name' => ['en' => 'Expenditure – Program Activities', 'lo' => 'ຄ່າໃຊ້ຈ່າຍ ກິດຈະກຳໂຄງການ'], 'type' => 'Expense', 'description' => 'Linked to DMF outputs (CCT, Graduation, SBCC, etc.)'],
            ['code' => '4100', 'name' => ['en' => 'Expenditure – Staff & Training', 'lo' => 'ຄ່າໃຊ້ຈ່າຍ ພະນັກງານ ແລະ ຝຶກອົບຮົມ'], 'type' => 'Expense', 'description' => 'PMU/PIU staffing, training'],
            ['code' => '4200', 'name' => ['en' => 'Expenditure – Assets & Equipment', 'lo' => 'ຄ່າໃຊ້ຈ່າຍ ຊັບສິນ ແລະ ອຸປະກອນ'], 'type' => 'Expense', 'description' => 'Vehicles, laptops, printers'],
            ['code' => '4300', 'name' => ['en' => 'Expenditure – Monitoring & Evaluation', 'lo' => 'ຄ່າໃຊ້ຈ່າຍ ການຕິດຕາມ ແລະ ປະເມີນ'], 'type' => 'Expense', 'description' => 'M&E, surveys, workshops'],
            ['code' => '5000', 'name' => ['en' => 'Exchange Gain/Loss', 'lo' => 'Commercial Exchange Gain/Loss'], 'type' => 'Adjustment', 'description' => 'Difference between fixed lot rate and actual']
        ];

        foreach ($accounts as $acc) {
            Account::firstOrCreate(['code' => $acc['code']], $acc);
        }

        // Create Fund Sources
        $donorA = FundSource::firstOrCreate(
            ['code' => 'FA'],
            [
                'name' => 'Donor A',
                'donor_name' => 'Donor A',
                'allocation_percentage' => 50.00,
                'initial_usd_balance' => 1000000.00,
                'available_usd_balance' => 1000000.00,
                'is_active' => true
            ]
        );
        $donorB = FundSource::firstOrCreate(
            ['code' => 'FB'],
            [
                'name' => 'Donor B',
                'donor_name' => 'Donor B',
                'allocation_percentage' => 25.00,
                'initial_usd_balance' => 500000.00,
                'available_usd_balance' => 500000.00,
                'is_active' => true
            ]
        );
        $donorC = FundSource::firstOrCreate(
            ['code' => 'FC'],
            [
                'name' => 'Donor C',
                'donor_name' => 'Donor C',
                'allocation_percentage' => 25.00,
                'initial_usd_balance' => 500000.00,
                'available_usd_balance' => 500000.00,
                'is_active' => true
            ]
        );

        // Create Q1 Lot with 10,000 USD amount at rate 22,000
        $lot = Lot::firstOrCreate(
            ['reference_number' => 'LOT-Q1-2026'],
            [
                'description' => 'Q1 2026 Fund Request',
                'requested_usd' => 10000.00,
                'exchange_rate' => 22000.00,
                'total_lak' => 220000000.00,
                'remaining_lak' => 220000000.00,
                'date_requested' => '2026-01-15',
                'is_exhausted' => false
            ]
        );
    }
}
