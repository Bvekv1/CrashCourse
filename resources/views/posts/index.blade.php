@extends('layouts.app')

@section ('content')
 <div class= "flex justify-center" >
     <div class ="w-8/12 bg-white p-6 rounded-lg">
        @Auth
     <form action="{{route('posts')}}" method="post" class="mb-4">
        @csrf
        <div class="mb-4">
            <label for="body" class="sr-only">Body</label>
            <textarea name="body" id="body" cols="30" rows="4" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror" placeholder="Post something!">
            </textarea>
            @error('body')
            <div class="text-red-500 mt-2 text-sm">
                {{$message}}
            </div>
                
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4py-2 rounded font-medium">
            Post
        </button> 
     </form>
   @endAuth
     @if($posts->count())
     @foreach ($posts as $post )
     <div class="mb-4">
     <a href="" class="font-bold">{{$post->user->name}}</a>
         <span class="text-gray-600
     text-sm">{{$post->created_at->diffForHumans()}}</span>
     <p class="mb-2">{{$post->body}}</p>
         @can('delete', $post)
        <div id="flex items-center">
        <form action="{{route('posts.destroy',$post)}}" method="post">
            @csrf  
            @method('DELETE')
            <button type="submit" class="text-blue-500">Delete</button>
            </form>
            @endcan
        </div>
        

     <div class="flex items-center">
         @if(!$post->likedBy(auth()->user()))
     <form action="{{route('count.likes', $post->id)}}" method="post" class="mr-1">
             @csrf
             <button type="submit" class="text-blue-500">Like</button>
         </form>
         @else
         <form action="{{route('count.likes',$post)}}" method="post" class="mr-1">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Unlike</button>
        </form>
        @endif
    <span>{{$post->likes->count()}} {{Str::plural('like', $post->likes->count())}} </span>
     </div>
     </div>
         
     @endforeach
     {{$posts->links()}}
     @else
     <P>There are no posts</P>
     @endif
 </div>
 </div>
 
@endsection