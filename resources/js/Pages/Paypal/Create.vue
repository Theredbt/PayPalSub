<template>
    <app-layout title="Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Subscription
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 max-w-xl mx-auto">
                        <form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="plan" value="Select a Plan" />
                                <select
                                        id="plan"
                                        name="plan"
                                        class="mt-1 block w-full sm:rounded-lg"
                                        v-model="form.plan"
                                        required
                                        @change="getPlanDetail(form.plan)"
                                >
                                    <option value="">Select a plan</option>
                                    <option
                                            v-for="plan in plans"
                                            :key="plan.id"
                                            :value="plan.id"
                                            :disabled="plan.status !== 'ACTIVE'">
                                        {{plan.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="p-6" v-if="planDetail">
                                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Subscription Details</h1>
                                <h6>
                                    ${{planDetail.billing_cycles[0].pricing_scheme.fixed_price.value}}
                                    {{planDetail.description}}</h6>
                                <div class="py-2 border-t border-gray-200"></div>
                                <div class="subscription-sub-item">
                                    <p class="sub-item-title text-gray-500">{{planDetail.name}}</p>
                                    <p class="sub-item-price">
                                        {{planDetail.billing_cycles[0].pricing_scheme.fixed_price.currency_code}}
                                        {{planDetail.billing_cycles[0].pricing_scheme.fixed_price.value}}
                                    </p>
                                </div>
                                <div class="subscription-sub-item">
                                    <p class="sub-item-title text-gray-500">Setup fee</p>
                                    <p class="sub-item-price">
                                        {{planDetail.payment_preferences.setup_fee.currency_code}}
                                        {{planDetail.payment_preferences.setup_fee.value}}
                                    </p>
                                </div>
                                <div class="py-2 border-t border-gray-200"></div>
                                <div class="subscription-sub-item">
                                    <p class="total-item-title text-gray-500">Total</p>
                                    <p class="total-item-price">
                                        {{planDetail.billing_cycles[0].pricing_scheme.fixed_price.currency_code}}
                                        {{planDetail.billing_cycles[0].pricing_scheme.fixed_price.value}}
                                    </p>
                                </div>
                            </div>
                        </form>
                        <paypal-subscription-button
                                v-if="form.plan"
                                :planId="form.plan"
                                :onApproved="onApproved"
                        ></paypal-subscription-button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import PaypalSubscriptionButton from '@/components/PaypalSubscriptionBtn.vue';

    export default defineComponent({
        props: ['plans'],

        components: {
            AppLayout,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetActionMessage,
            JetSecondaryButton,
            JetButton,
            PaypalSubscriptionButton
        },

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'POST',
                    plan: this.plan
                }),
                planDetail: null
            }
        },

        methods: {
            async getPlanDetail(plan_id){
                if (plan_id) {

                    axios.get(route('plan.detail'), { params: {plan_id}})
                        .then(res => this.planDetail = res.data)
                        .catch(error => this.planDetail = null);
                }else {
                    this.planDetail = null;
                }
            },

            async onApproved(data, actions) {

                const form = this.$inertia.form({
                    _method: 'GET',
                    subscription_id: data.subscriptionID
                });

                form.get(route('subscription.success'), {
                    onSuccess: () => console.log('success')
                });
            },

            async test(){
                const form = this.$inertia.form({
                    _method: 'GET',
                    subscription_id: 'I-A7UYBR2C6ER1'
                });

                form.get(route('subscription.success'), {
                    onSuccess: () => console.log('success')
                });
            }
        }
    })
</script>

<style scoped>
    .subscription-sub-item {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
    .sub-item-title {
        font-size: 15px;
    }
    .sub-item-price {
        font-size: 15px;
        color: #2563eb;
    }

    .total-item-title {
        font-size: 20px;
    }

    .total-item-price {
        font-size: 20px;
        color: #2563eb;
    }
</style>