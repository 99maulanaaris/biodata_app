<x-app-layout title="Login" :sidebar="false">
    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh">
        <x-form title="Login" buttonTitle="Login" :isLogin="true" url="{{ route('register') }}" action="{{ route('store.login') }}"/>
    </div>
</x-app-layout>


