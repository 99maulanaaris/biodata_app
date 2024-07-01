<x-app-layout title="Register" :sidebar="false">
    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh">
        <x-form title="Register" buttonTitle="Register" :isLogin="false" url="{{ route('login') }}" action="{{ route('store.register') }}"/>
    </div>
</x-app-layout>


