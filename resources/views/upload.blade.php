@extends('layout.app')

@section('content')
    <section class="container container-fluid">
        <h1>Загрузка файла</h1>

        <div>
            <input type="file"
                   class="file-to-upload"
                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            />

            <button type="button" class="send-file">Загрузить</button>
        </div>

        <div>
            Обработано строк:
            <span class="ws-progress">0</span>
        </div>
    </section>
@endsection
