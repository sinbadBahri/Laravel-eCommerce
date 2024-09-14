@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Blog Posts List</h4>
                    <div class="add-product">
                        <a href="/admin-panel/blog/create-post">Create New Post</a>
                    </div>
                    <br>
                    <br>

                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Genres</th>
                            <th>Description(Body)</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Setting</th>
                        </tr>
                        @foreach ($blogPosts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            @if ($post->genres !== null)
                            <td>
                            @foreach ($post->genres as $genre)
                                {{$genre->title}} , 
                            @endforeach    
                            </td>    
                            @else
                            <td>Uncategorized</td>
                            
                            @endif
                            <td>{{substr($post->description, 0, 100)}} ...</td>
                            <td>
                                @if ($post->status)
                                    <button class="pd-setting">Published</button>
                                @else
                                    <button class="ds-setting">Draft</button>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="" method="post">
                                    @csrf
                                    <button data-toggle="tooltip" title="Edit" class="pd-setting-ed" name="edit_post_id" value="{{$post->id}}">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <form action="delete-post" method="POST">
                                    @csrf
                                    <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" name="trash_post_id" value="{{$post->id}}">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div class="custom-pagination">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
