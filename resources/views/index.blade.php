@extends('master')

@section('content')
    <div class="row py-5 px-0">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session()->get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="col-md-4">
            <form action="{{route('notes.store')}}" method="post"> @csrf
                <div class="mb-3">
                    <label for="title"><b>Title</b></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid  @enderror" value="{{old('title')}}" placeholder="Enter note title">
                    @error('title')
                        <span class="invalid-feedback">{{$message}}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content"><b>Content</b></label>
                    <textarea name="content" rows="5" id="content" class="form-control @error('title') is-invalid  @enderror" placeholder="Enter yourt notes"></textarea>
                    @error('content')
                    <span class="invalid-feedback">{{$message}}</span>
                @enderror
                </div>
                <div class="mb-3">
                    <button name="createNoteBtn" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <b>Total : {{count($notes)}}</b>
                <div class="row g-2">

                    @foreach ($notes as $note)
                    {{-- @if (Auth::user()->id == $note->user_id) --}}
                        <div class="col-md-6">
                            <div class="rounded p-2 border border-primary">
                                <h5 class="pb-3">{{$note->title}}</h5>
                                <p class="pb-3">{{$note->content}}</p>
                                <div class="my-1 d-flex justify-content-between">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{{route('notes.edit',$note->id)}}}" class="dropdown-item">Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{route('notes.destroy',$note->id)}}" method="POST" id="deleteForm{{$note->id}}" class="d-none"> @csrf @method('delete') </form>
                                                {{-- <a href="" onclick="event.preventDefault(); document.getElementById('deleteForm').submit()" class="dropdown-item">Delete</a> --}}
                                                <button class="dropdown-item" onclick="myFun({{$note->id}})">Delete</button>
                                            </li>
                                            <li>
                                                <form action="{{route('notes.copy',$note->id)}}" method="POST" id="copyForm{{$note->id}}" class="d-none"> @csrf </form>
                                                <a href="" onclick="event.preventDefault(); document.getElementById('copyForm{{$note->id}}').submit()" class="dropdown-item">Copy</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-bs-toggle="modal" href="#shareModal{{$note->id}}">Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>{{date('d-M-Y', strtotime($note->created_at))}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="shareModal{{$note->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" action="{{url('notes/'.$note->id.'/share')}}"> @csrf 
                                    <div class="modal-body">
                                        <input type="text" name="receiver_email" class="form-control" required placeholder="Enter email address">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="shareBtn" class="btn btn-primary">Share Note</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    @endforeach       
                </div>
        </div>
    </div>
@endsection
<script>
    function myFun(id) {
        if( confirm('are you sure to delete? ') ) {
            document.getElementById('deleteForm'+id).submit()
        }
    }
</script>