<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ cinema + ': добавление кинозала' }}
            </div>

            <div class="card-header">
                Добавить ряд
            </div>
            <div class="card-body">
                <add-rows-component
                    :places="placesArray"
                    @addRows="addRows"
                    @setWidthOfHall="setWidthOfHall"
                ></add-rows-component>
            </div>
            <div class="card-header">
                Вид зала
            </div>
            <div class="card-body">
                <rows-component :rows="rows" :width="width" :seats="seats" :cinemaId="id"></rows-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'cinema',
            'places',
            'id'
        ],
        data: function () {
            return {
                name: "",
                placesArray: [],
                rows: [],
                width: 0,
                seats: 0
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.placesArray = JSON.parse(this.places);
        },
        methods: {
            addRows(rows) {
                this.rows = rows;
            },
            setWidthOfHall(width, seats) {
                this.width = width;
                this.seats = seats;
            }
        },
    }
</script>