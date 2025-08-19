@props(['errors'])

@if ($errors->any())

<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <div class="text-center">
        <div {{ $attributes }}>
            <div class="font-medium text-red-600">
                {{ __("Oops! erreur de connexion ou votre compte a été bloqué.") }}
            </div>
            <div class="font-medium text-red-600">
                {{ __("Si le problème persiste veuillez contacter votre Administrateur.") }}
            </div>

           
        </div>
    </div>
</div>
@endif
