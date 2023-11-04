@extends('master')

@section('content')
    <form action="{{route('notes.update',$note->id)}}" method="post"> @csrf @method('put')
        <div class="mb-3">
            <label for="title"><b>Title</b></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid  @enderror" value="{{old('title') ?? $note->title}}" placeholder="Enter note title">
            @error('content')
                <span class="invalid-feedback">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content"><b>Content</b></label>
            <textarea name="content" rows="5" id="content" class="form-control @error('content') is-invalid  @enderror" placeholder="Enter yourt notes">{{old('content') ?? $note->content}}</textarea>
            @error('content')
                <span class="invalid-feedback">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection