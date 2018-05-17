@extends('layout')

@section('content')
    <main class="container py-5">
        <h1 class="mt-0 mb-4">
            Alle pagina's
            <a class="btn-link float-right" href="{{ route('pages.create') }}">
                <button class="btn btn-outline-dark">
                    Creëer een pagina
                </button>
            </a>
        </h1>
        <table class="table m-0">
            <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td class="pt-0 pb-4">
                    <span class="table-span">
                        {{ ucfirst($page['title']) }}
                        {{--<a title="Info" data-toggle="collapse" href="#multiCollapseExample{{ $page['id'] }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample{{ $page['id'] }}">--}}
                            {{--<img class="info-icon" src="{{ asset('images/info.png') }}" alt="Info icon">--}}
                        {{--</a>--}}
                    </span>
                        <div class="float-right">
                            <a href="/{{ str_replace(' ', '-', $page['link']) }}" target="_blank"><img src="{{ asset('images/eye.png') }}" alt="Eye icon" title="View"></a>
                            <a href="{{ route('pages.edit', $page['id']) }}" class="n-button"><img src="{{ asset('images/pencil.png') }}" alt="Edit icon" title="Edit"></a>
                            <form action="{{ route('pages.destroy', $page['id']) }}" method="POST" class="n-button">
                                @method('DELETE')
                                @csrf
                                <button class="delete-btn" onclick="return confirm('Ben je zeker dat je deze pagina wilt verwijderen?')"><img src="{{ asset('images/cancel-button.png') }}" alt="Delete icon" title="Delete"></button>
                            </form>
                        </div>
                        {{--<div class="collapse-wrapper">--}}
                            {{--<div class="collapse multi-collapse" id="multiCollapseExample{{ $page['id'] }}">--}}
                                {{--<div class="card card-body">--}}
                                    {{--<p>Aangemaakt op: {{ $page['created_at'] }}</p>--}}
                                    {{--<p>Laatst aangepast op: {{ $page['updated_at'] }}</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </main>

@endsection