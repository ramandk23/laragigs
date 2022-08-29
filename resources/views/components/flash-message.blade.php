@if(session()->has('message'))
<div x-data="{show:true}"  x-transition x-init="setTimeout(() => show=false, 4000)" x-show="show" class="fixed top-0 left-1/4 transform bg-laravel text-white px-48 py-3">
<p>
    {{session('message')}}
</p>
</div>
@endif
