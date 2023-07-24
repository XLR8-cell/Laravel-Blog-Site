<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
#use Symfony\Component\Mime\Part\File;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }
    public static function all()
    {
        // $files = File::files(resource_path("posts"));
        // return array_map(function($file) { return $file->getContents(); }, $files);
        return cache()->rememberForever('posts.all', fn()=>collect($files = File::files(resource_path("posts"))) #closure to arrow function
            ->map(function ($file) {

                $document = YamlFrontMatter::parseFile($file);

                return new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug
                );
            })
            ->sortByDesc('date'));
    }
    public static function find($slug)
    {
        $posts = static::all();

        return $posts->firstWhere('slug', $slug);

        //     if (!file_exists($path = resource_path("posts/{$slug}.html"))) {

        //         # ddd('This page does not exist');
        //         #abort(404);
        //         #return redirect("/");
        //         throw new ModelNotFoundException();
        //         #return $path;
        //     }
        //     return cache()->remember("posts/{$slug}", 5, function () use ($path) {
        //         return $post = file_get_contents($path);
        //     });

        //     //     return cache()->remember("posts/{$slug}", 5, fn() => $post = file_get_contents($path)); #remember is a method call on the cache manager. It checks if the given key (in this case, "posts/{$slug}") exists in the cache.
        //     //         #If the key exists in the cache, the associated value is retrieved and returned. If the key does not exist or has expired (the cache duration is 5 minutes in this example), the callback function provided as the third argument is executed.

    }
}
