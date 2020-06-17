<template>
    <div class="row">
        <div class="col-lg-6">
            <new-place-component :option="option"></new-place-component>
        </div>
        <div class="col-lg-6">
            <new-option-component @sendingNewOption="sendingNewOption"></new-option-component>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                option: []
            }
        },
        mounted() {
            console.log('AddNewPlaceComponent mounted.');
        },
        methods: {
            sendingNewOption(option) {
                this.option = option;
            }
        },
    }
</script>
