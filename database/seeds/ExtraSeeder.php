<?php

use Illuminate\Database\Seeder;
use Antoree\Models\Role;
use Antoree\Models\Permission;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $compose_learning_resources_permission = Permission::create([
            'name' => 'compose-learning-resources',
            'display_name' => 'Compose learning resources',
            'description' => 'Add/Edit/Delete learning resources such as courses, lessons, tests'
        ]);
        $learning_contributor_role = Role::create(array(
            'public' => false,
            'name' => 'learning-contributor',
            'display_name' => 'Learning Contributor',
            'description' => 'Compose learning resources such as courses, lessons, tests'
        ));
        $roles = Role::where('name', 'learning-editor')
            ->orWhere('name', 'learning-contributor')
            ->orWhere('name', 'teacher')
            ->get();
        foreach ($roles as $role) {
            $role->attachPermission($compose_learning_resources_permission);
        }
    }
}
