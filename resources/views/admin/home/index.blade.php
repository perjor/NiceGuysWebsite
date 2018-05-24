@extends('layout')

@section('content')
    <main class="container py-5">
        <h1 class="mt-0 mb-4">
            Alle Home Blocks
            <div class="float-right">
                <button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target=".multicollapse" aria-expanded="false" aria-controls="multicollapse">Volgorde aanpassen</button>
                <a class="btn-link" href="{{ route('home.create') }}">
                    <button class="btn btn-outline-dark">
                        Creëer een home block
                    </button>
                </a>
            </div>
        </h1>
        <table class="table m-0">
            <tbody>
            @foreach ($blocks as $block)
                <tr>
                    <td class="pt-0 pb-4">
                        <span class="table-span">
                            {{ isset($block['title']) ? ucfirst($block['title']) : $block['video'] }}
                        </span>
                    </td>
                    <td class="collapse multicollapse">
                        <input class="order-input" type="text">
                    </td>
                    <td>
                        <div class="float-right">
                            <a href="{{ route('home.edit', $block['id']) }}" class="n-button"><img src="{{ asset('images/pencil.png') }}" alt="Edit icon" title="Edit"></a>
                            <form action="{{ route('home.destroy', $block['id']) }}" method="POST" class="n-button">
                                @method('DELETE')
                                @csrf
                                <button class="delete-btn" onclick="return confirm('Ben je zeker dat je deze Home Block wilt verwijderen?')"><img src="{{ asset('images/cancel-button.png') }}" alt="Delete icon" title="Delete"></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </main>

@endsection