<template>
    <app-layout title="Subscriptions">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subscription Detail
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <table class="w-full">
                            <thead>
                            <th class="border-b">Plan</th>
                            <th class="border-b">Plan Description</th>
                            <th class="border-b">Status</th>
                            <th class="border-b">Start time</th>
                            <th class="border-b">Next billing time</th>
                            </thead>
                            <tbody>
                            <td class="text-center">{{subscription.plan_name}}</td>
                            <td class="text-center">{{subscription.plan_description}}</td>
                            <td class="text-center">{{subscription.status}}</td>
                            <td class="text-center">{{subscription.start_time}}</td>
                            <td class="text-center">{{subscription.next_billing}}</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        props: ['subscription'],

        components: {
            AppLayout
        }
    })
</script>

<style scoped>

</style>