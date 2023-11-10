<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title mt-lawyer-title" style="margin-bottom: 30px">
            <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
            <h2 class="text-center"><span>Адвокат</span></h2>
        </div>
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-header text-center">
                            Фотографии адвоката
                        </div>
                        <div class="card-body">
                            <div id="carouselExampleControls" class="carousel carousel-dark slide"
                                 data-bs-ride="carousel">
                                <div class="carousel-inner" style="height:300px">
                                    <div class="carousel-item" v-if="lawyer_info.images.length>0"
                                         v-bind:class="{'active':index===0}"
                                         v-for="(image,index) in lawyer_info.images">
                                        <img :src="image" class="d-block w-100" alt="..."
                                             style="object-fit: contain;height: 300px;">
                                    </div>
                                    <div class="carousel-item active" v-else>
                                        <img src="/photos/lawyer.png" class="d-block w-100" alt="..."
                                             style="object-fit: contain;height: 300px;">
                                    </div>
                                </div>
                                <template v-if="lawyer_info.images.length>0">
                                    <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-md-2 mt-sm-2 mt-2 mt-lg-0">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-header text-center">
                            Информация об адвокате
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th scope="row">ФИО</th>
                                        <td>{{ lawyer_info.second_name }} {{ lawyer_info.first_name }}
                                            {{ lawyer_info.middle_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Номер телефона</th>
                                        <td>{{ lawyer_info.number_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Университет</th>
                                        <td>{{ lawyer_info.university.name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Уровень образования</th>
                                        <td>{{ lawyer_info.level_education }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Дата принятия на работу</th>
                                        <td>{{ getCorrectFormatData(lawyer_info.hire_date) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Стаж работы</th>
                                        <td>
                                            Количество лет: {{ getDiffYears(lawyer_info.hire_date) }}<br>Количество
                                            месяцев: {{ getDiffMonths(lawyer_info.hire_date) }}<br>Количество дней:
                                            {{ getDiffDays(lawyer_info.hire_date) }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3 border border-danger rounded-3 p-3 mb-5" v-if="lawyer_info.services.length>0">
                <h6 class="text-center">Услуги адвоката</h6>
                <count-elements-table-page
                    @changeCountElementsTable="changeCountElementsTable"
                    :prop_name_table_elements="'services'"
                ></count-elements-table-page>
                <div class="table-responsive">
                    <table class="table mt-2">
                        <thead>
                        <tr>
                            <th scope="col">Номер услуги</th>
                            <th scope="col">Название услуги</th>
                            <th scope="col">Специализация</th>
                            <th scope="col">Стоимость</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(service, index) in paginatedServices">
                            <td>{{ index + 1 }}</td>
                            <td>{{ service.name }}</td>
                            <td>{{ service.specialization.name }}</td>
                            <td>{{ service.pivot.cost }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination
                    @handlePaginateData="handlePaginateData"
                    :array="lawyer_info.services"
                    :maxVisiblePages="maxVisiblePages"
                    :itemsOnPage="itemsOnPageService"
                    :namePagination="'services'"
                ></pagination>
            </div>

        </div>

        <div class="about-area about-area-two mb-5" v-if="lawyer_instances_percentages.length>0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="about-progress">
                            <h2 class="text-center">Показатели выигранных дел по специализации</h2>
                            <div class="progress-contant" v-for="instance_percentage in lawyer_instances_percentages">
                                <h3>
                                    {{ instance_percentage.name }}<span>{{ PrintStrPercentage(instance_percentage.win_percentage) }}</span>
                                </h3>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         :style="{width: PrintStrPercentage(instance_percentage.win_percentage)}"
                                         :aria-valuenow="PrintStrPercentage(instance_percentage.win_percentage)"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <my-footer></my-footer>
    </fragment>
</template>

<script>
import moment from 'moment'

export default {
    name: "LawyerPage",
    data() {
        return {
            lawyer_info: {default: null},
            breadcrumbs: {default: null},
            lawyer_instances_percentages: {default: []},
            today_date: moment(),
            paginatedServices: [],
            maxVisiblePages: 3,
            itemsOnPageService: {default:0}
        }
    },
    props: {
        prop_lawyer_info: {default: null},
        prop_breadcrumbs: {default: null},
        prop_lawyer_instances_percentages: {default: null}
    },
    methods: {
        changeCountElementsTable(data)
        {
            if(data.name_table === 'services')
            {
                this.itemsOnPageService = data.count;
            }
        },
        parseFloatStrPercentage(str_percentage) {
            return parseFloat(str_percentage)
        },
        PrintStrPercentage(str_percentage) {
            if (str_percentage.endsWith(".00")) {
                return str_percentage.slice(0, -3) + "%";
            }
            return str_percentage + "%"
        },
        handlePaginateData(data) {
            if (data.namePagination === 'services') {
                this.paginatedServices = data.itemsForPage;
            }
        },
        getCorrectFormatData(str_date) {
            return moment(str_date).format('DD/MM/YYYY');
        },
        getDiffYears(str_date) {
            const hire_date = moment(str_date);
            const duration = moment.duration(this.today_date.diff(hire_date));
            return duration.years();
        },
        getDiffMonths(str_date) {
            const hire_date = moment(str_date);
            const duration = moment.duration(this.today_date.diff(hire_date));
            return duration.months();
        },
        getDiffDays(str_date) {
            const hire_date = moment(str_date);
            const duration = moment.duration(this.today_date.diff(hire_date));
            return duration.days();
        }
    },
    created() {
        this.lawyer_info = this.prop_lawyer_info;
        this.breadcrumbs = this.prop_breadcrumbs;
        this.lawyer_instances_percentages = this.prop_lawyer_instances_percentages;
        console.log("Страница адвоката");
        console.log(this.lawyer_instances_percentages);

    }
}
</script>

<style scoped>

</style>
