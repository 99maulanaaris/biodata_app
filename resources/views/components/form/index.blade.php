<h1>{{ $title }}</h1>
<form class="mt-4" autocomplete="false" method="POST" action="{{ $action }}">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    @if ($isLogin)
        <div class="mb-3 form-check">
            <a href="{{ $url }}">Belum Punya Account ?</a>
        </div>
    @else
        <div class="mb-3 form-check">
            <a href="{{ $url }}">Sudah Punya Account ?</a>
        </div>
    @endif
    <button type="submit" class="btn btn-primary">{{ $buttonTitle }}</button>
</form>
