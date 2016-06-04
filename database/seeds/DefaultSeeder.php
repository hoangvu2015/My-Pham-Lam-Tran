<?php

use Illuminate\Database\Seeder;
use Antoree\Models\Permission;
use Antoree\Models\Role;
use Antoree\Models\User;
use Antoree\Models\RealtimeChannel;

class DefaultSeeder extends Seeder
{
    public function run()
    {
        $admin_access_permission = Permission::create([
            'name' => 'access-admin',
            'display_name' => 'Access admin',
            'description' => 'Access admin pages'
        ]);

        $compose_blog_article_permission = Permission::create([
            'name' => 'compose-blog-articles',
            'display_name' => 'Compose blog articles',
            'description' => 'Add/Edit/Delete blog articles'
        ]);

        $compose_learning_resources_permission = Permission::create([
            'name' => 'compose-learning-resources',
            'display_name' => 'Compose learning resources',
            'description' => 'Add/Edit/Delete learning resources such as courses, lessons, tests'
        ]);

        $admin_role = Role::create(array(
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Manage system\'s operation'
        ));
        $admin_role->attachPermission($admin_access_permission);

        $learning_manager_role = Role::create(array(
            'public' => false,
            'name' => 'learning-manager',
            'display_name' => 'Learning Manager',
            'description' => 'Manage learning items such as teachers, students, learning requests'
        ));
        $learning_manager_role->attachPermission($admin_access_permission);

        $learning_editor_role = Role::create(array(
            'public' => false,
            'name' => 'learning-editor',
            'display_name' => 'Learning Editor',
            'description' => 'Manage learning resources such as topics, courses, lessons, tests'
        ));
        $learning_editor_role->attachPermission($admin_access_permission);
        $learning_editor_role->attachPermission($compose_learning_resources_permission);

        $learning_contributor_role = Role::create(array(
            'public' => false,
            'name' => 'learning-contributor',
            'display_name' => 'Learning Contributor',
            'description' => 'Compose learning resources such as courses, lessons, tests'
        ));
        $learning_contributor_role->attachPermission($compose_learning_resources_permission);

        $blog_editor_role = Role::create(array(
            'public' => false,
            'name' => 'blog-editor',
            'display_name' => 'Blog Editor',
            'description' => 'Manage blog items'
        ));
        $blog_editor_role->attachPermission($admin_access_permission);
        $blog_editor_role->attachPermission($compose_blog_article_permission);

        $blog_contributor_role = Role::create(array(
            'public' => false,
            'name' => 'blog-contributor',
            'display_name' => 'Blog Contributor',
            'description' => 'Compose blog articles'
        ));
        $blog_contributor_role->attachPermission($compose_blog_article_permission);

        Role::create(array(
            'public' => false,
            'name' => 'supporter',
            'display_name' => 'Supporter',
            'description' => 'Help students to make their best choices'
        ));
        Role::create(array(
            'public' => true,
            'name' => 'student',
            'display_name' => 'Student',
            'description' => 'Learning courses'
        ));
        $teacher_role = Role::create(array(
            'public' => true,
            'name' => 'teacher',
            'display_name' => 'Teacher',
            'description' => 'Teaching students'
        ));
        $teacher_role->attachPermission($compose_blog_article_permission);
        $teacher_role->attachPermission($compose_learning_resources_permission);

        // TODO: Add 1 administrator
        $channel = RealtimeChannel::create([
            'secret' => RealtimeChannel::generateKey('nt_'),
            'type' => 'notification'
        ]);
        $admin = User::create(array(
            'name' => 'Admin',
            'email' => 'admin@antoree.com',
            'password' => bcrypt('123456'),
            'slug' => 'admin',
            'channel_id' => $channel->id,
            'activation_code' => str_random(32),
            'active' => true
        ));
        $admin->attachRole($admin_role);
        $admin->attachRole($learning_manager_role);
        $admin->attachRole($learning_editor_role);
        $admin->attachRole($blog_editor_role);
    }
}
