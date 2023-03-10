@extends('layouts.app')

@section('content')
    @livewire('components.posts.post-show', ['post' => $post], key($post->id))
@endsection
