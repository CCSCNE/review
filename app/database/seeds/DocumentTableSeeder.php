<?php

class DocumentTableSeeder extends Seeder {

    public static function delUploads()
    {
        $dir = __DIR__ . '/../../../uploads';
        $files = array_diff(scandir($dir), array('.','..','.gitignore'));
        foreach ($files as $file)
        {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return;
    }

    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file)
        {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('documents')->truncate();

        self::delUploads();

        // Categories
        foreach(Category::all() as $cat)
        {
            $document = new Document;
            $src = realpath(__DIR__ . '/../samples_files/');
            $dest = realpath(__DIR__ . '/../../../uploads/');
            $document->saved_name = $faker->file($src, $dest);
            $document->name = str_replace('.', '_', str_replace(' ', '_', $faker->sentence(3)));
            $document->container_id = $cat->id;
            $document->container_type = 'categories';
            $document->user_id = 1;
            $document->save();
        }

        // Submissions
        foreach(Submission::all() as $cat)
        {
            $document = new Document;
            $src = realpath(__DIR__ . '/../samples_files/');
            $dest = realpath(__DIR__ . '/../../../uploads/');
            $document->saved_name = $faker->file($src, $dest);
            $document->name = str_replace('.', '_', str_replace(' ', '_', $faker->sentence(3)));
            $document->container_id = $cat->id;
            $document->container_type = 'submissions';
            $document->user_id = 1;
            $document->save();
        }

        // Reviews
        foreach(Review::all() as $cat)
        {
            $document = new Document;
            $src = realpath(__DIR__ . '/../samples_files/');
            $dest = realpath(__DIR__ . '/../../../uploads/');
            $document->saved_name = $faker->file($src, $dest);
            $document->name = str_replace('.', '_', str_replace(' ', '_', $faker->sentence(3)));
            $document->container_id = $cat->id;
            $document->container_type = 'reviews';
            $document->user_id = 1;
            $document->save();
        }

    }

}
