<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="choose-area about-page-area pt-100">
            <div class="container mt-specialization-title">
                <div class="section-title text-center">
                    <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    <template v-if="getCountWordsInNameSpecialization().length === 2">
                        <h2><span>{{ getCountWordsInNameSpecialization()[0] }}</span>{{
                                ' '
                            }}{{ getCountWordsInNameSpecialization()[1] }}
                        </h2>
                    </template>
                    <template v-else>
                        <h2>{{ local_basic_spec_info.name }}</h2>
                    </template>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="attor-details-item d-flex h-100">
                        <div class="attor-details-left">
                            <div class="pt-5">
                                <h3 class="text-center">Краткие сведения о направлении</h3>
                                <p>{{ local_basic_spec_info.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12" v-if="!all_status_zero">
                    <div class="attor-details-item h-100">
                        <div class="attor-details-left">
                            <div class="pt-5">
                                <chart-pie :dataChart="chartData"
                                           :title="'Диаграмма дел агенства в данной специализации'"
                                ></chart-pie>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-2 mb-5" v-if="local_lawyers.length>0">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2>Наши специалисты</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" v-for="lawyer in paginated_lawyers">
                    <div class="attorney-card h-100 d-flex flex-column">
                        <div class="row">
                            <div class="col-12 text-center">
                                <a :href="'/lawyer/'+lawyer.id">
                                    <template v-if="lawyer.images.length>0">
                                        <img :src="lawyer.images[0]" alt="Image"
                                             style="height: 300px;object-fit: contain;">
                                    </template>
                                    <template v-else>
                                        <img src="/photos/lawyer.png" alt="Image"
                                             style="height: 300px;object-fit: contain;">
                                    </template>
                                </a>
                            </div>
                            <div class="col-12">
                                <div class="attorney-card-text">
                                    <h3><a :href="'/lawyer/'+lawyer.id">{{ lawyer.second_name }} {{ lawyer.first_name }}
                                        {{ lawyer.middle_name }}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <pagination
                    @handlePaginateData="handlePaginateData"
                    :array="local_lawyers"
                    :maxVisiblePages="maxVisiblePages"
                    :itemsOnPage="itemsOnPage"
                    :namePagination="'lawyers'"
                ></pagination>
            </div>
        </div>
        <div class="container mt-2 mb-5" v-if="local_services.length>0">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2>Наши услуги</h2>
                    </div>
                </div>
                <div class="col-12">
                    <count-elements-table-page
                        @changeCountElementsTable="changeCountElementsTable"
                        :prop_name_table_elements="'service'"
                    ></count-elements-table-page>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Номер услуги</th>
                                <th scope="col">Наименование услуги</th>
                                <th scope="col">Адвокат</th>
                                <th scope="col">Стоимость</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(service, index) in paginated_services">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ service.name }}</td>
                                <td>{{ service.second_name }} {{ service.first_name }} {{ service.middle_name }}</td>
                                <td>{{ service.cost }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <pagination
                    @handlePaginateData="handlePaginateData"
                    :array="local_services"
                    :maxVisiblePages="maxVisiblePages"
                    :itemsOnPage="itemsOnPageInstance"
                    :namePagination="'service'"
                ></pagination>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
export default {
    name: "SpecializationPage",
    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: []
                    }
                ]
            },
            local_spec_info: {default: null},
            local_basic_spec_info: {default: null},
            local_lawyers: [],
            local_services: [],
            paginated_lawyers: [],
            paginated_services: [],
            itemsOnPageInstance: {default:0},
            maxVisiblePages: 3,
            itemsOnPage: 3,
            breadcrumbs: {default: null},
            all_status_zero: {default: true}
        }
    },
    props: {
        spec_info: {default: null},
        basic_spec_info: {default: null},
        lawyers: [],
        services: [],
        prop_breadcrumbs: {default: null}
    },
    methods: {
        changeCountElementsTable(data)
        {
            if(data.name_table === 'service')
            {
                this.itemsOnPageInstance = data.count;
            }
        },
        getCountWordsInNameSpecialization() {
            return this.local_basic_spec_info.name.split(" ");
        },
        getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        handlePaginateData(data) {
            if (data.namePagination === 'lawyers') {
                this.paginated_lawyers = data.itemsForPage;
            }
            if (data.namePagination === "service") {
                this.paginated_services = data.itemsForPage;
            }
        },
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
        this.local_spec_info = this.spec_info;
        this.local_basic_spec_info = this.basic_spec_info;
        this.local_lawyers = this.lawyers;
        this.local_services = this.services;
        this.spec_info.forEach((item) => {
            this.chartData.labels.push(item.status);
            if (this.all_status_zero && item.count_instances) {
                this.all_status_zero = false;
            }
            this.chartData.datasets[0].data.push(item.count_instances);
            this.chartData.datasets[0].backgroundColor.push(this.getRandomColor());
        });

        this.local_lawyers.forEach((lawyer) => {
            if (typeof lawyer.images === 'string') {
                lawyer.images = JSON.parse(lawyer.images);

            }
        })
        console.log(this.chartData);
    }
}
</script>

<style scoped>

</style>
