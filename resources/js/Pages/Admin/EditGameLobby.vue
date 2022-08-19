<script setup>
import Logo from '@/Shared/SVG/Logo';
import TextInput from '@/Shared/Inputs/TextInput';
import { ref, onMounted } from 'vue';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import { intersectionTypeAnnotation } from '@babel/types';
import { Inertia } from '@inertiajs/inertia';


let updaterForm = useForm({
    name: props.gameLobby.data.name,
    image:props.gameLobby.data.image_url,
    theme_color:props.gameLobby.data.theme_color,
    type:props.gameLobby.data.type,
    rules:props.gameLobby.data.rules,
    base_entrance_fee:props.gameLobby.data.base_entrance_fee,
    description:props.gameLobby.data.description,
    available_spots:props.gameLobby.data.available_spots,
    
    
});

let props = defineProps({
    gameLobby:Object
});

function updateGameLobby(id){
    Inertia.put(route('gamelobby-update',id), updaterForm)
    
}


</script>
<template>
    <!-- <div class=" h-full max-w-3xl rounded-lg bg-white p-6">
        <div class="aspect-w-16 aspect-h-9 mb-4">
            <img class="rounded-lg" :src="gameLobby.data.image_url"
                :alt="`${game.name} - ${gameLobby.data.name} Art`" />
        </div>
        <div class="mb-4 flex flex-row justify-between">
            <h2 class="font-grota text-xl font-extrabold uppercase text-wgh-gray-6">
                {{ gameLobby.data.name }}
            </h2>
            <div class="text-bold font-grota text-base text-wgh-gray-6">
                <span>{{ gameLobby.data.base_entrance_fee }} {{ gameLobby.data.asset.symbol }}</span>
            </div>
        </div>

        </div> -->
    <form @submit.prevent="updateGameLobby">

        <h1>name</h1>
        <TextInput v-model="updaterForm.name" type="text" id="name" class="mb-6 mt-4 " />
        <h1>image_url</h1>
        <TextInput v-model="updaterForm.image" type="text" id="image" class="mb-6 mt-4 " />
        <h1>theme_color</h1>
        <TextInput v-model=" updaterForm.theme_color" type="text" id="theme_color" class="mb-6 mt-4 " />
        <h1>type</h1>
        <TextInput v-model="updaterForm.type" type="text" id="type" class="mb-6 mt-4 " />
        <h1>rules</h1>
        <TextInput v-model="updaterForm.rules" type="text" id="rules" class="mb-6 mt-4 " />
        <h1>base_entrance_fee</h1>
        <TextInput v-model=" updaterForm.base_entrance_fee" type="text" id="base_entrance_fee" class="mb-6 mt-4 " />
        <h1>description</h1>
        <TextInput v-model="updaterForm.description" type="text" id="description" class="mb-6 mt-4 " />
        <h1>available_spots</h1>
        <TextInput v-model="updaterForm.available_spots" type="text" id="available_spots" class="mb-6 mt-4 " />
        
        
    </form>
    <button @click="updateGameLobby(gameLobby.data.id)" class="w-full">
        <ButtonShape type="purple">
            <span class="w-full uppercase">update</span>
        </ButtonShape>
    </button>
</template>

