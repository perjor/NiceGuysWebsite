<form method="post" action="{{url('admin/home', $homeblock['id'] )}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group mt-0 mb-4">
        <label for="title">Titel:</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ $homeblock->title }}">
    </div>
    <div class="form-group mt-0 mb-4">
        <label for="text">Body:</label>
        <textarea class="form-control" name="text" id="text">{{ $homeblock['text'] }}</textarea>
    </div>
    <div class="form-group mt-0 mb-4">
        <label for="color">Achtergrond kleur:</label>
        <input type="color" class="form-control color-input" name="color" id="color" value="{{ $homeblock->color }}">
    </div>
    <div class="form-group mt-0 mb-4">
        <label for="font">Tekst kleur:</label>
        <div class="form-control p-2">
            <div class="d-block">
                <input class="gallery-radio" id="white2" name="font" type="radio" value="white" {{ ($homeblock->font_color == "white") ? "checked" : "" }}>
                <label for="white2" class="mb-0 ml-2">Wit</label>
            </div>
            <div class="d-block">
                <input class="gallery-radio" id="black2" name="font" type="radio" value="black" {{ ($homeblock->font_color == "black") ? "checked" : "" }}>
                <label for="black2" class="mb-0 ml-2">Zwart</label>
            </div>
        </div>
    </div>
    <div class="form-group mt-0 mb-4" style="margin-top:60px">
        <button type="submit" class="btn btn-success">Bevestigen</button>
        <a class="btn btn-danger" href="{{ URL::previous() }}">Annuleren</a>
    </div>
    <script>
        CKEDITOR.replace('text');
    </script>
</form>