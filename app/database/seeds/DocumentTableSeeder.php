<?php

class DocumentTableSeeder extends Seeder {

    private $faker;

    public function run()
    {
        $this->faker = Faker\Factory::create();
        DB::table('documents')->truncate();

        self::delUploads();

        // Categories
        foreach(Category::all() as $cat)
        {
            $this->genDocument($cat, 'Category');
        }

        // Submissions
        foreach(Submission::all() as $cat)
        {
            $this->genDocument($cat, 'Submission');
        }

        // Reviews
        foreach(Review::all() as $cat)
        {
            $this->genDocument($cat, 'Review');
        }

    }

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

    public function genDocument($container, $container_type)
    {
        $document = new Document;
        $src = realpath(__DIR__ . '/../samples_files/');
        $dest = realpath(__DIR__ . '/../../../uploads/');
        $document->saved_name = $this->faker->file($src, $dest);
        $document->saved_name = $this->relativePath(realpath($dest), $document->saved_name);
        $filename = $this->faker->sentence(3);
        $filename = substr($filename, 0, strlen($filename)-1);
        $filename = str_replace(' ', '_', $filename);
        $filename = str_replace('.', '_', $filename);
        $document->name = $filename . '.' . pathinfo($document->saved_name, PATHINFO_EXTENSION);
        $document->container_id = $container->id;
        $document->container_type = $container_type;
        $document->user_id = 1;
        $document->save();
    }

    function relativePath($from, $to, $ps = DIRECTORY_SEPARATOR)
    {
        $arFrom = explode($ps, rtrim($from, $ps));
        $arTo = explode($ps, rtrim($to, $ps));
        while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0]))
        {
            array_shift($arFrom);
            array_shift($arTo);
        }
        return str_pad("", count($arFrom) * 3, '..'.$ps).implode($ps, $arTo);
    }
}
