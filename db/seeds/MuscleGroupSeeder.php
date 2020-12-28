<?php


use Phinx\Seed\AbstractSeed;

class MuscleGroupSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
               'name' => 'Back & Biceps'
            ],
            [
                'name' => 'Chest & Triceps'
            ],
            [
                'name' => 'Shoulders'
            ],
            [
                'name' => 'Arms'
            ],
            [
                'name' => 'Legs'
            ],
            [
                'name' => 'Back'
            ],
            [
                'name' => 'Chest'
            ],
            [
                'name' => 'Quads'
            ],
            [
                'name' => 'Hamstrings'
            ],
            [
                'name' => 'Calves'
            ],
            [
                'name' => 'Biceps'
            ],
            [
                'name' => 'Triceps'
            ],
            [
                'name' => 'Core'
            ]
        ];

        $posts = $this->table('muscle_groups');
        $posts->insert($data)
            ->save();
    }
}
