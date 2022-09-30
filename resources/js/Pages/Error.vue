<template>
    <div class="min-h-full bg-white px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
        <div class="mx-auto max-w-max">
            <main class="sm:flex">
                <p class="text-4xl font-bold tracking-tight text-indigo-600 sm:text-5xl">{{ status }}</p>
                <div class="sm:ml-6">
                    <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{ title }}</h1>
                        <p class="mt-1 text-base text-gray-500">
                            {{ description }}
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import AuthLayout from '@/Layouts/_BaseLayout';

export default {
    layout: AuthLayout,
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: 'Service Unavailable',
                500: 'Server Error',
                404: 'Page Not Found',
                403: 'Forbidden',
            }[this.status];
        },
        description() {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon.',
                500: 'Whoops, something went wrong on our servers.',
                404: 'Sorry, the page you are looking for could not be found.',
                403: 'Sorry, you are forbidden from accessing this page.',
            }[this.status];
        },
    },
};
</script>
