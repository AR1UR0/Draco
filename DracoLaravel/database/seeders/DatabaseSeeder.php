<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
* Seeder Maestro: DatabaseSeeder
* * Main class responsible for coordinating the bulk insertion of initial data.
* It's an orchestrator to ensure that the database goes
* from being empty to having a complete functional structure with a single command.
* * @author Marta
*/
class DatabaseSeeder extends Seeder
{
    /**
    * Main execution method.
    * Defines the critical order for data "seeding" to respect
    * the referential integrity of the database.
    * @author Marta
    */
    public function run(): void
    {
        $this->call([
            // 1. Identity: Create the roles and the initial administrator user.
            RoleUserSeeder::class, 
            // 2. Structure: Create the global categories
            TematicaSeeder::class,  
            // 3. Content: The most complex seeder that inserts the test logic.
            TestSeeder::class, 
        ]);
    }
}