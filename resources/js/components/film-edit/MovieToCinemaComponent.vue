<template>
    <div class="row">
        <div class="col-lg-6">
            <button v-on:click="allCinemas" :class="allButtonClass" style="margin-bottom: 3px;">Все кинотеатры</button>

            <div class="row">
                <div class="col-lg-6">
                   <multiselect
                        v-model="selectedCountries"
                        :options="countries"
                        :multiple="true"
                        :close-on-select="false"
                        :placeholder="'Выберите страны'"
                        :selectLabel="'Нажмите enter чтобы выбрать'"
                        :selectedLabel="'Выбрана'"
                        :deselectLabel="'Нажмите enter чтобы убрать'"
                        @close="onCloseCountriesSelector"
                    ></multiselect>
                </div>
                <div class="col-lg-6">
                    <multiselect
                            v-model="selectedCities"
                            :options="cities"
                            :multiple="true"
                            :close-on-select="false"
                            :placeholder="'Выберите города'"
                            :selectLabel="'Нажмите enter чтобы выбрать'"
                            :selectedLabel="'Выбран'"
                            :deselectLabel="'Нажмите enter чтобы убрать'"
                            @close="onCloseCitiesSelector"
                    ></multiselect>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <label for="allHalls" style="margin: 0">
                    <input type="checkbox" id="allHalls" v-model="allHalls"> Выбрать все кинозалы
                </label>
            </div>
            <button v-show="selectedHalls.length !==0" v-on:click="acceptSelected" class="btn btn-primary" style="margin-bottom: 3px;">Применить</button>
            <div v-for="cinema in result" class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ cinema.name }}</h5>
                    <p class="card-text">{{ cinema.address.country }}, {{ cinema.address.city }}</p>
                    <!--<div class="input-group">-->
                        <!--<label :for="'cinema' + cinema.id" style="margin: 0">-->
                            <!--<input type="checkbox" :id="'cinema' + cinema.id"> Выбрать весь кинотеатр-->
                        <!--</label>-->
                    <!--</div>-->
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="hall in cinema.hall" v-if="hall.status === 1">
                        <div class="container-fluid">
                            <h5 class="card-title">{{ hall.name }}</h5>
                            <p class="card-text">Возможные сборы фильма с одного сеанса: {{ hall.seats * price }}</p>
                            <div class="input-group">
                                <label :for="'hall' + hall.id" style="margin: 0">
                                    <input type="checkbox" :id="'hall' + hall.id" v-model="selectedHalls" :value="hall.id"> Выбрать зал
                                </label>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'price',
            'filmid'
        ],
        data: function () {
            return {
                all:                true,
                allButtonClass:     'btn btn-primary',
                cinemas:            [],
                countries:          [],
                cities:             [],
                selectedCountries:  [],
                selectedCities:     [],
                result:             [],
                numberOfHalls:      0,
                dataCopy:           [],
                selectedHalls:      []
            }
        },
        computed: {
            allHalls: {
                get() {
                    return this.selectedHalls.length === this.numberOfHalls;
                },
                set(val) {
                    this.selectedHalls = val == true ? this.getIDsOfHalls() : [];
                }
            }
        },
        watch: {

        },
        mounted() {
            console.log('Component mounted.');
            this.getCinemas();
            this.getCountries();
        },
        methods: {
            acceptSelected: function () {
                axios.post('/film/set-films-to-halls', {
                    ids: this.selectedHalls,
                    film_id: this.filmid
                }).then((response) => {
                    window.location.href = '/session/create';
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
            getIDsOfHalls: function () {
                let data = [];
                for (let i = 0; i < this.result.length; i++) {
                    for (let j = 0; j < this.result[i].hall.length; j++) {
                        data.push(this.result[i].hall[j].id);
                    }
                }
                return data;
            },
            onCloseCitiesSelector: function () {
                let result = [];
                for (let i = 0; i < this.selectedCities.length; i++) {
                    let city = this.selectedCities[i].split(': ');
                    // console.log(city);
                    let searchResult = this.result.filter(c => c.address.city === city[1]);
                    for (let j = 0; j < searchResult.length; j++) {
                        result.push(searchResult[j]);
                    }
                }
                this.result = result.sort();
                this.countHalls();
            },
            onCloseCountriesSelector: function () {
                this.changeAllButton();
                let result = [];
                for (let i = 0; i < this.selectedCountries.length; i++) {
                    let searchResult = this.cinemas.filter(c => c.address.country === this.selectedCountries[i]);
                    for (let j = 0; j < searchResult.length; j++) {
                        this.cities.push(searchResult[j].address.country + ': ' + searchResult[j].address.city);
                        result.push(searchResult[j]);
                    }
                }
                this.result = result.sort();
                this.countHalls();
            },
            allCinemas: function() {
                if (this.all === true) {
                    this.all = false;
                    this.allButtonClass = 'btn btn-outline-primary';
                    this.result = this.dataCopy;
                    this.dataCopy = [];
                }
                else {
                    this.all = true;
                    this.allButtonClass = 'btn btn-primary';
                    this.selectedCountries = [];
                    this.dataCopy = this.result;
                    this.result = this.cinemas;
                }
            },
            changeAllButton: function () {
                this.all = false;
                this.allButtonClass = 'btn btn-outline-primary';
            },
            countHalls: function () {
                let count = 0;
                this.numberOfHalls = this.result.reduce(
                    (accumulator, cinema) => accumulator + cinema.hall.length,
                    count
                );
            },
            getCinemas: function () {
                axios.get('/get-cinemas').then((response) => {
                    if (response.data.cinemas) {
                        this.cinemas = JSON.parse(response.data.cinemas);
                        this.result = this.cinemas;
                        this.countHalls();
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
            getCountries: function () {
                axios.get('/address/get-countries').then((response) => {
                    if (response.data.countries) {
                        let data = JSON.parse(response.data.countries);
                        for (let i =0; i < data.length; i++) {
                            this.countries.push(data[i].country);
                        }
                        this.countries.sort();
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>
























































<!--<template>-->
    <!--<div class="row">-->
        <!--<div class="col-lg-3">-->
            <!--<div class="form-group">-->
                <!--<label for="countries">Страна:</label>-->
                <!--<select v-model="selectedCountries" v-bind:onchange="getCities()" multiple class="form-control" id="countries">-->
                    <!--<option disabled>Выберите страну...</option>-->
                    <!--<option v-for="country in countries">{{ country }}</option>-->
                <!--</select>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="col-lg-3">-->
            <!--<div class="form-group">-->
                <!--<label for="cities">Страна:</label>-->
                <!--<select v-model="selectedCities" multiple class="form-control" id="cities">-->
                    <!--<option disabled>Выберите город...</option>-->
                    <!--<option v-for="city in cities">{{ city }}</option>-->
                <!--</select>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="col-lg-6">-->
            <!--<div v-for="(cinema, index) in cinemas" class="card mb-3">-->
                <!--<div class="card-header">-->
                    <!--<div class="input-group">-->
                        <!--<p style="margin: 0"><input type="checkbox" :value="cinema.id"> {{ cinema.name }}</p>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<ul class="list-group list-group-flush">-->
                    <!--<li class="list-group-item" v-for="hall in cinema.hall" v-if="hall.status === 1">-->
                        <!--<div class="input-group">-->
                            <!--<p style="margin: 0"><input type="checkbox"> {{ hall.name }} - {{ hall.seats }}</p>-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</template>-->

<!--<script>-->
    <!--export default {-->
        <!--props: [-->

        <!--],-->
        <!--data: function () {-->
            <!--return {-->
                <!--countries:          [],-->
                <!--cinemas:            [],-->
                <!--selectedCountries:  [],-->
                <!--cities:             [],-->
                <!--selectedCities:     []-->
            <!--}-->
        <!--},-->
        <!--mounted() {-->
            <!--console.log('Component mounted.');-->
            <!--this.getCountries();-->
            <!--this.getCinemas();-->
        <!--},-->
        <!--methods: {-->
            <!--getCountries: function () {-->
                <!--axios.get('/address/get-countries').then((response) => {-->
                    <!--if (response.data.countries) {-->
                        <!--let data = JSON.parse(response.data.countries);-->
                        <!--for (let i =0; i < data.length; i++) {-->
                            <!--this.countries.push(data[i].country);-->
                        <!--}-->
                        <!--this.countries.sort();-->
                    <!--}-->
                <!--}).catch(error => {-->
                    <!--// here catch error messages from laravel validator and show them-->
                <!--});-->
            <!--},-->
            <!--getCities: function () {-->
                <!--axios.get('/address/get-cities', JSON.stringify(this.selectedCountries)).then((response) => {-->
                    <!--this.cities = JSON.parse(response.data.cities);-->
                <!--}).catch(error => {-->
                    <!--// here catch error messages from laravel validator and show them-->
                <!--});-->
            <!--},-->
            <!--getCinemas: function () {-->
                <!--axios.get('/get-cinemas').then((response) => {-->
                    <!--if (response.data.cinemas) {-->
                        <!--this.cinemas = JSON.parse(response.data.cinemas);-->
                    <!--}-->
                <!--}).catch(error => {-->
                    <!--// here catch error messages from laravel validator and show them-->
                <!--});-->
            <!--},-->
        <!--}-->
    <!--}-->
<!--</script>-->