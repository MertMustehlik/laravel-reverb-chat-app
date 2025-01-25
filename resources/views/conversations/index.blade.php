@extends("template")
@section("title", 'Conversations')
@section("master")
    <div class="card">
        <div class="card-header">
            <h3>Conversations</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                @foreach($conversations as $item)
                    <a href="{{route('conversations.show', ['conversation' => $item->id])}}" class="list-group-item list-group-item-action">{{$item->name}}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
