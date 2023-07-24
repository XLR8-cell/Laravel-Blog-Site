<!DOCTYPE html>

<title>My blog </title>
<link rel="stylesheet" href="/app.css">

<body>
    @foreach ($posts as $post)
    <article>

        <h1>
            <a href="posts/{{$post->slug}}">
                {{$post->title}}
            </a>
        </h1>

        <div>
            <p>{{$post->excerpt}}</p>
        </div>

    </article>

    @endforeach

</body>
<?php // since $posts is an array of objects, $post is an object each representing each html file. 
 ?>