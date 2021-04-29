@extends('layouts.app')


@section('title', 'Blog Posts')

@section('content')
{{--    @each('posts.partials.post', $posts, 'post')--}}
    @forelse($posts as $key=> $post)
        @include('posts.partials.post', [])
    @empty
        No blog posts yet!
    @endforelse

    {{--    <h1>hello world!</h1>--}}
    {{--    <div>--}}
    {{--        @for ($i=0;$i <10; $i++)--}}
    {{--            <div>The current value is {{$i}}</div>--}}
    {{--        @endfor--}}
    {{--    </div>--}}
    {{--    <div>--}}
    {{--        @php $done = false @endphp--}}

    {{--        @while(!$done)--}}
    {{--            <div>--}}
    {{--                I'm not done--}}
    {{--            </div>--}}

    {{--            @php--}}
    {{--            if(random_int(0,1) === 1) $done = true--}}
    {{--            @endphp--}}
    {{--        @endwhile--}}
    {{--    </div>--}}
@endsection
