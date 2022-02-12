<template>
    <div id="subscription-button"></div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['planId', 'onApproved'],

        mounted() {

            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical',
                    label: 'subscribe'
                },
                createSubscription: (data, actions) =>{
                    return actions.subscription.create({
                        plan_id: this.planId
                    });
                },
                onApprove: this.onApproved
            }).render('#subscription-button');
        }
    })
</script>

<style scoped>

</style>