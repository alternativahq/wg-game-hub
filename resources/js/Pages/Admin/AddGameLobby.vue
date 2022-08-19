<script setup>
import Logo from '@/Shared/SVG/Logo';
import TextInput from '@/Shared/Inputs/TextInput';
import { ref, onMounted } from 'vue';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import { intersectionTypeAnnotation } from '@babel/types';
import { Inertia } from '@inertiajs/inertia';

let props = defineProps({
    games:Array,

});

let AddForm = useForm({
    name: '',
    image: '',
    theme_color: '',
    type: '',
    rules: '',
    base_entrance_fee: '',
    description: '',
    available_spots: '',
    game_name:'',


});



function addGameLobby() {
    Inertia.post(route('admin/game-lobies.store'), AddForm)

}

</script>
<template>

    <form @submit.prevent="addGameLobby">

        <h1>name</h1>
        <TextInput v-model="AddForm.name" type="text" id="name" class="mb-6 mt-4 " />
        <h1>image_url</h1>
        <TextInput v-model="AddForm.image" type="text" id="image" class="mb-6 mt-4 " />
        <h1>theme_color</h1>
        <TextInput v-model=" AddForm.theme_color" type="text" id="theme_color" class="mb-6 mt-4 " />
        <h1>type</h1>
        <TextInput v-model="AddForm.type" type="text" id="type" class="mb-6 mt-4 " />
        <h1>rules</h1>
        <TextInput v-model="AddForm.rules" type="text" id="rules" class="mb-6 mt-4 " />
        <h1>base_entrance_fee</h1>
        <TextInput v-model=" AddForm.base_entrance_fee" type="text" id="base_entrance_fee" class="mb-6 mt-4 " />
        <h1>description</h1>
        <TextInput v-model="AddForm.description" type="text" id="description" class="mb-6 mt-4 " />
        <h1>available_spots</h1>
        <TextInput v-model="AddForm.available_spots" type="text" id="available_spots" class="mb-6 mt-4 " />
        <h1>GAME</h1>
        <select name="game_name" id="game_name" v-model="AddForm.game_name" class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal
        text-wgh-gray-6 placeholder-wgh-gray-3 outline-none mb-5">

            <option v-for="game in props.games" >{{ game.name }}</option>
        </select>


    </form>
    <button @click="addGameLobby()" class="w-full">
        <ButtonShape type="purple">
            <span class="w-full uppercase">ADD</span>
        </ButtonShape>
    </button>
</template>

