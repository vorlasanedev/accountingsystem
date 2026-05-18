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

        // Create sample Account
        $account = Account::firstOrCreate(
            ['code' => 'EXP-001'],
            ['name' => 'General Expenses', 'type' => 'Expense']
        );

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
                'date_requested' => '2026-01-15',
                'is_exhausted' => false
            ]
        );
    }
}
