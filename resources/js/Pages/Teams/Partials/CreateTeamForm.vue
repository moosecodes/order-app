<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/Inertia/FormSection.vue";
import InputError from "@/Components/Inertia/InputError.vue";
import InputLabel from "@/Components/Inertia/InputLabel.vue";
import PrimaryButton from "@/Components/Inertia/PrimaryButton.vue";
import TextInput from "@/Components/Inertia/TextInput.vue";

const form = useForm({
    name: "",
});

const createTeam = () => {
    form.post(route("teams.stores"), {
        errorBag: "createTeam",
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createTeam">
        <template #title> Team Details </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel value="Team Owner" />

                <div class="mt-2 flex items-center">
                    <img
                        class="h-12 w-12 rounded-full object-cover"
                        :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name"
                    />

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.props.user.name }}</div>
                        <div class="text-sm text-gray-700">
                            {{ $page.props.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Team Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>
