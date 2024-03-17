<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    links: {
        type: Array
    },
    flash: {
        type: Object,
        required: true
    }
});

const form = useForm({
    url: '',
})
</script>

<template>
    <GuestLayout>
        <Head title="Add link"/>

        <div v-if="$page.props.flash.message" class="mb-4 rounded px-4 py-2" :class="$page.props.flash.status">
            {{ $page.props.flash.message }}
        </div>

        <div class="bg-gray-50 py-2 text-black/50 dark:bg-black dark:text-white/50 sm:px-6 lg:px-8">
            <h2 class="my-4 font-medium">Add new link</h2>
            <form @submit.prevent="form.post(route('store'))" class="mb-10 flex w-full items-center gap-4">
                <div class="form-group">
                    <TextInput
                        id="url"
                        type="text"
                        v-model="form.url"
                        :disabled="form.processing"
                        placeholder="Url"
                    />
                    <InputError :message="form.errors.url"/>
                </div>

                <div>
                    <PrimaryButton :disabled="form.processing">Add url</PrimaryButton>
                </div>
            </form>

            <div class="flex flex-col">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-sm">
                                    Url
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-sm">
                                    Hash
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="link in links" :key="link.id" class="border-b bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    {{ link.url }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm underline">
                                    <a :href="link.url" target="_blank">{{ link.hash }}</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
