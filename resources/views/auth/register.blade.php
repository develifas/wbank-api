<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
      </a>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div>
        <x-label for="name" :value="__('Nome')" />

        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
      </div>

      <div>
        <x-label for="cpf" :value="__('CPF')" />
        
        <x-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" required autofocus />
      </div>

      <div>
        <x-label for="birthday" :value="__('Data de nascimento')" />

        <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required autofocus />
      </div>

      <div>
        <x-label for="mother" :value="__('Nome da mãe')" />

        <x-input id="mother" class="block mt-1 w-full" type="text" name="mother" :value="old('mother')" required autofocus />
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <x-label for="email" :value="__('Email')" />

        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-label for="password" :value="__('Password')" />

        <x-input id="password" class="block mt-1 w-full"
                 type="password"
                 name="password"
                 required autocomplete="new-password" />
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <x-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-input id="password_confirmation" class="block mt-1 w-full"
                 type="password"
                 name="password_confirmation" required />
      </div>
      
      <div>
        <x-label for="phone" :value="__('Telefone')" />

        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
      </div>

      <div>
        <x-label for="zipcode" :value="__('CEP')" />

        <x-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="old('zipcode')" required autofocus />
      </div>

      <div>
        <x-label for="state" :value="__('Estado (UF)')" />

        <x-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state')" required autofocus />
      </div>

      <div>
        <x-label for="city" :value="__('Cidade')" />

        <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus />
      </div>

      <div>
        <x-label for="district" :value="__('Bairro')" />

        <x-input id="district" class="block mt-1 w-full" type="text" name="district" :value="old('district')" required autofocus />
      </div>

      <div>
        <x-label for="address" :value="__('Endereço')" />
        
        <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus />
      </div>
      
      <div>
        <x-label for="number" :value="__('Número')" />
        
        <x-input id="mumber" class="block mt-1 w-full" type="text" name="number" :value="old('number')" required autofocus />
      </div>
      
      <div>
        <x-label for="publicPlace" :value="__('Logradouro')" />
        
        <x-input id="publicPlace" class="block mt-1 w-full" type="text" name="public_place" :value="old('public_place')" required autofocus />
      </div>
      <div>
        <x-label for="complement" :value="__('complemento')" />
        
        <x-input id="complement" class="block mt-1 w-full" type="text" name="complement" :value="old('complement')" required autofocus />
      </div>
      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>

        <x-button class="ml-4">
          {{ __('Register') }}
        </x-button>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>
