<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Account;
use App\Models\FundSource;
use App\Models\Transaction;

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
        $fundA = FundSource::firstOrCreate(
            ['code' => 'FA'],
            ['name' => 'Fund A', 'donor_name' => 'World Bank', 'allocation_percentage' => 90.91]
        );
        $fundB = FundSource::firstOrCreate(
            ['code' => 'FB'],
            ['name' => 'Fund B', 'donor_name' => 'ADB', 'allocation_percentage' => 4.55]
        );
        $fundC = FundSource::firstOrCreate(
            ['code' => 'FC'],
            ['name' => 'Fund C', 'donor_name' => 'UNDP', 'allocation_percentage' => 4.54]
        );

        // Create a simple transaction
        $transaction = Transaction::create([
            'reference_number' => 'TRX-' . time(),
            'type' => 'Expenditure',
            'account_id' => $account->id,
            'description' => 'Sample transaction for testing allocations',
            'total_amount' => 220000,
            'status' => 'Draft',
            'created_by' => $user->id,
        ]);

        // Adjust the auto-generated splits to be exactly the requested amounts
        $transaction->splits()->where('fund_source_id', $fundA->id)->update(['amount' => 200000]);
        $transaction->splits()->where('fund_source_id', $fundB->id)->update(['amount' => 10000]);
        $transaction->splits()->where('fund_source_id', $fundC->id)->update(['amount' => 10000]);
    }
}
