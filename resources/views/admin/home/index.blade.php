@extends('layout')

@section('content')
    <main class="container py-5">
        <h1 class="mt-0 mb-4">
            <span class="kiddishmedium">
                Alle homeblocks
            </span>
            <a class="btn-link float-sm-right" href="{{ route('home.create') }}">
                <button class="btn btn-outline-dark">
                    Creëer een homeblock
                </button>
            </a>
        </h1>
        @foreach ($blocks as $block)
            <div class="modal fade" id="exampleModal{{$block['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>Bent u zeker dat u het block met id: {{ $block['id'] }} wilt verwijderen?</p>
                            <form action="{{ route('home.destroy', $block['id']) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Annuleren</button>
                                <button type="submit" class="btn btn-success">Verwijderen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <form method="post" action="{{route('admin.order.update')}}">
            @csrf
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Block id</th>
                    <th scope="col">Soort</th>
                    <th scope="col">Volgorde</th>
                    <th scope="col">Acties</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($blocks as $key => $block)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                @if ($block['type'] == 1)
                                    Titel, tekstveld en foto.
                                @elseif ($block['type'] == 2)
                                    Titel en tekstveld.
                                @elseif ($block['type'] == 3)
                                    Titel en foto.
                                @elseif ($block['type'] == 4)
                                    Foto
                                @elseif ($block['type'] == 5)
                                    Video
                                @elseif ($block['type'] == 6)
                                    Teller
                                @endif
                            </td>
                            <td>
                                <input class="order-input form-control mr-0" type="number" min="1" max="{{ count($blocks) }}" value="{{ $block['order'] }}" name="{{ $block['id'] }}">
                            </td>
                            <td>
                                <a href="/admin/home/{{$block['id']}}/edit?type={{$block['type']}}" class="n-button"><img src="{{ asset('images/pencil.png') }}" alt="Edit icon" title="Aanpassen"></a>
                                <button type="button" class="delete-btn" data-toggle="modal" data-target="#exampleModal{{$block['id']}}" title="Verwijderen">
                                    <img src="{{ asset('images/cancel-button.png') }}">
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit"  id="order-btn" class="invisible btn btn-success">Aanpassen</button>
            <button type="button" id="order-decline-btn" class="invisible btn btn-danger">Annuleren</button>
        </form>
    </main>

@endsection
