<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title mt-service-title" style="margin-bottom: 30px">
            <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
            <h2>Наши <span>услуги</span></h2>
        </div>
        <div class="container">
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-lg-3 col-md-12">
                    <div class="form-check">
                        <h5>Фильтр по специальностям</h5>
                        <div class="col-12 " v-for="specialization in specializations">
                            <input class="form-check-input" type="checkbox" value=""
                                   @change="ChangeCheckBox(specialization.id, 'specializations')"
                                   :checked="specialization.selected"
                                   :id="'specialization-'+specialization.id">
                            <label class="form-check-label" :for="'specialization-'+specialization.id">
                                {{ specialization.name }}
                            </label>
                        </div>

                        <h5>Фильтр по адвокатам</h5>
                        <div class="col-12 " v-for="lawyer in lawyers">
                            <input class="form-check-input" type="checkbox" value=""
                                   @change="ChangeCheckBox(lawyer.id, 'lawyers')"
                                   :checked="lawyer.selected"
                                   :id="'lawyer-'+lawyer.id">
                            <label class="form-check-label" :for="'specialization-'+lawyer.id">
                                {{ lawyer.second_name }} {{ lawyer.first_name }} {{ lawyer.middle_name }}
                            </label>
                        </div>
                        <h5>Цена</h5>
                        <div class="col-12">
                            <vue-slider
                                v-model="sliderValue"
                                :min="min_cost"
                                :max="max_cost"
                                :interval="1"
                            ></vue-slider>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button @click="ReloadPageWithFilters" class="default-btn-one w-100"
                                    style="pointer-events: all; cursor: pointer;">Применить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <template v-if="services.length>0">
                        <count-elements-table-page
                            @changeCountElementsTable="changeCountElementsTable"
                            :prop_name_table_elements="'services'"
                        ></count-elements-table-page>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Номер услуги</th>
                                    <th scope="col">Наименование услуги</th>
                                    <th scope="col">Специализация</th>
                                    <th scope="col">Адвокат</th>
                                    <th scope="col">Стоимость</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(service,index) in paginatedServices">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ service.service_name }}</td>
                                    <td>{{ service.name_specialization }}</td>
                                    <td>{{ service.full_name }}</td>
                                    <td>{{ service.cost }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <pagination
                                class="mb-5"
                                @handlePaginateData="handlePaginateData"
                                :array="services"
                                :maxVisiblePages="maxVisiblePages"
                                :itemsOnPage="itemsOnPageService"
                                :namePagination="'services'"
                            ></pagination>
                        </div>
                    </template>
                    <div class="row" v-else>
                        <div class="col-12 text-center">
                            <h3>Услуги по выбранным критериям не найдены!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';

export default {
    name: "ServicesPage",
    data() {
        return {
            selected_specializations: [],
            selected_lawyers: [],
            paginatedServices: [],
            maxVisiblePages: 3,
            //itemsOnPage: 10,
            sliderValue: [0, 0],
            min_cost: 0,
            max_cost: 0,
            breadcrumbs: [],
            itemsOnPageService: {default:0}
        }
    },
    components: {
        VueSlider
    },
    props: {
        specializations: {default: null},
        services: {default: null},
        lawyers: {default: null},
        all_min_cost: {default: null},
        all_max_cost: {default: null},
        prop_breadcrumbs: {default: null}
    },
    methods: {
        changeCountElementsTable(data)
        {
            if(data.name_table === 'services')
            {
                this.itemsOnPageService = data.count;
            }
        },
        handlePaginateData(data) {
            if (data.namePagination === 'services') {
                this.paginatedServices = data.itemsForPage;
            }
        },
        ChangeCheckBox(id, type) {
            let link = null;
            if (type === "specializations") {
                link = this.selected_specializations;
            } else if (type === "lawyers") {
                link = this.selected_lawyers;
            }
            if (event.target.checked) {
                if (link !== null) {
                    link.push(id)
                }
            } else {
                if (link !== null) {
                    const index = link.indexOf(id);
                    if (index > -1) {
                        link.splice(index, 1);
                    }
                }
            }
        },
        ReloadPageWithFilters() {
            //"/lawyers?specializations=" + this.selected_specializations;
            console.log("min_cost");
            console.log(this.sliderValue[0]);
            console.log("max_cost");
            console.log(this.sliderValue[1]);
            let base_url = null;
            if (this.selected_specializations.length <= 0 && this.selected_lawyers.length <= 0 && this.sliderValue[0] === 0 && this.sliderValue[1] === 0) {
                base_url = "/services";
            } else {
                console.log("Сука");
                let queryParams = {
                    specializations: this.selected_specializations,
                    lawyers: this.selected_lawyers,
                    min_cost: this.sliderValue[0],
                    max_cost: this.sliderValue[1],
                }
                let queryString = Object.keys(queryParams).map((key) => {
                    if (queryParams[key].length > 0 || Number.isInteger(queryParams[key])) {
                        return `${key}=${queryParams[key]}`
                    } else {
                        return null;
                    }
                }).filter(param => param !== null).join("&");
                base_url = '/services?' + queryString;
                console.log(base_url);
            }
            window.location = base_url;
        },
        setInitialValueForRangeSlider() {
            try {
                this.sliderValue[0] = parseInt(new URLSearchParams(window.location.search).get('min_cost')) || 0;
                if (this.sliderValue[0] < this.min_cost || this.sliderValue[0] > this.max_cost) {
                    this.sliderValue[0] = this.min_cost;
                }
            } catch (error) {
                this.sliderValue[0] = 0;
                console.log("min_value_error");
                console.log(error);
            }
            try {
                this.sliderValue[1] = parseInt(new URLSearchParams(window.location.search).get('max_cost')) || 0;
                if (this.sliderValue[1] < this.min_cost || this.sliderValue[1] > this.max_cost) {
                    this.sliderValue[1] = this.max_cost;
                }
            } catch (error) {
                this.sliderValue[1] = 0;
                console.log("max_value_error");
                console.log(error);
            }
            console.log("Сука");
            console.log(this.sliderValue);
        }
    },
    created() {
        this.specializations.forEach((specialization) => {
            if (specialization.selected) {
                this.selected_specializations.push(specialization.id);
            }
        });
        this.lawyers.forEach((lawyer) => {
            if (lawyer.selected) {
                this.selected_lawyers.push(lawyer.id);
            }
        });
        if (this.all_min_cost !== null) {
            try {
                this.min_cost = parseInt(this.all_min_cost);
            } catch (e) {
                console.log("Ошибка", e);
            }
        }
        if (this.all_max_cost !== null) {
            try {
                this.max_cost = parseInt(this.all_max_cost);
            } catch (e) {
                console.log("Ошибка", e);
            }
        }
        this.setInitialValueForRangeSlider();
        this.breadcrumbs = this.prop_breadcrumbs;
    }
}
</script>

<style scoped>
.slider {
    /* overwrite slider styles */
    width: 200px;
}
</style>
