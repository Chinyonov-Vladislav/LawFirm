<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title text-center mt-lawyers-title" style="margin-bottom: 30px">
            <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
            <h2>Наши <span>профессионалы</span></h2>
        </div>
        <div class="container">
            <div class="row" style="margin-bottom: 30px;">

                <div class="col-lg-3 col-md-12">
                    <div class="form-check">
                        <h5>Фильтр по специальностям</h5>
                        <div class="col-12 " v-for="specialization in specializations">
                            <input class="form-check-input" type="checkbox" value=""
                                   @change="ChangeCheckBox(specialization.id)"
                                   :checked="specialization.selected"
                                   :id="'specialization-'+specialization.id">
                            <label class="form-check-label" :for="'specialization-'+specialization.id">
                                {{ specialization.name }}
                            </label>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button @click="ReloadPageWithFilters" class="default-btn-one w-100"
                                    style="pointer-events: all; cursor: pointer;">Применить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 mt-xl-0 mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                    <div class="row" v-if="lawyers.length>0">
                        <div class="col-lg-4 col-sm-6 margin_bottom_card_lawyer" v-for="lawyer in paginatedLawyers">
                            <div class="attorney-card d-flex flex-column h-100">
                                <a :href="'/lawyer/'+lawyer.id">
                                    <img class="image_lawyer" :src="lawyer.images[0]" alt="Image"
                                         v-if="lawyer.images.length>0">
                                    <img class="image_lawyer" src="/photos/lawyer.png" alt="Image" v-else>
                                </a>
                                <div class="hr-theme-slash-2">
                                    <div class="hr-line"></div>
                                    <div class="hr-icon"><i class="las la-user-tie"></i></div>
                                    <div class="hr-line"></div>
                                </div>
                                <div class="attorney-card-text my_padding_for_card_text">
                                    <h3><a :href="'/lawyer/'+lawyer.id">{{ lawyer.second_name }} {{ lawyer.first_name }}
                                        {{ lawyer.middle_name }}</a></h3>
                                    <template v-if="lawyer.specializations.length > 0">
                                        <div class="hr-theme-slash-2">
                                            <div class="hr-line"></div>
                                            <div class="hr-icon"><i class="lar la-star"></i></div>
                                            <div class="hr-line"></div>
                                        </div>
                                        <div class="row">
                                            <h6>Специализации</h6>
                                            <p v-for="specialization in lawyer.specializations"><i
                                                class="las la-star"></i>{{ specialization.specialization_name }}</p>
                                        </div>
                                    </template>
                                    <template v-if="lawyer.hire_date !== null">
                                        <div class="hr-theme-slash-2">
                                            <div class="hr-line"></div>
                                            <div class="hr-icon"><i class="lar la-calendar-check"></i></div>
                                            <div class="hr-line"></div>
                                        </div>
                                        <div class="row">
                                            <h6>Опыт работы</h6>
                                            <p>Количество лет: {{getDiffYears(lawyer.hire_date)}}</p>
                                            <p>Количество месяцев: {{getDiffMonths(lawyer.hire_date)}}</p>
                                            <p>Количество дней: {{getDiffDays(lawyer.hire_date)}}</p>
                                        </div>
                                    </template>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a :href="'/lawyer/'+lawyer.id" class="default-btn-one w-100"
                                       style="pointer-events: all; cursor: pointer;">Подробнее</a>
                                </div>
                            </div>
                        </div>
                        <pagination
                            class="mb-5"
                            @handlePaginateData="handlePaginateData"
                            :array="lawyers"
                            :maxVisiblePages="maxVisiblePages"
                            :itemsOnPage="itemsOnPage"
                            :namePagination="'lawyers'"
                        ></pagination>
                    </div>
                    <div class="row" v-else>
                        <div class="col-12 text-center">
                            <h3>Адвокаты по выбранным специальностям не найдены!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import moment from 'moment';

export default {
    name: "LawyersPage",
    data() {
        return {
            itemsOnPage: 6,
            currentPage: 1,
            maxVisiblePages: 3,
            paginatedLawyers: [],
            selected_specializations: [],
            today_date: moment(),
            breadcrumbs: null
        }
    },
    methods: {
        getDiffYears(str_date)
        {
            const hire_date = moment(str_date);
            const duration = moment.duration(this.today_date.diff(hire_date));
            return duration.years();
        },
        getDiffMonths(str_date)
        {
            const hire_date = moment(str_date);
            const duration = moment.duration(this.today_date.diff(hire_date));
            return duration.months();
        },
        getDiffDays(str_date)
        {
            const hire_date = moment(str_date);
            const duration = moment.duration(this.today_date.diff(hire_date));
            return duration.days();
        },
        handlePaginateData(data) {
            if (data.namePagination === 'lawyers') {
                this.paginatedLawyers = data.itemsForPage;
            }
        },
        ChangeCheckBox(specialization_id) {
            if (event.target.checked) {
                this.selected_specializations.push(specialization_id)
            } else {
                const index = this.selected_specializations.indexOf(specialization_id);
                if (index > -1) {
                    this.selected_specializations.splice(index, 1);
                }
            }
        },
        ReloadPageWithFilters() {
            //"/lawyers?specializations=" + this.selected_specializations;
            let base_url = null;
            if (this.selected_specializations.length > 0) {
                base_url = "/lawyers?specializations=" + this.selected_specializations;
            } else {
                base_url = "/lawyers";
            }
            window.location = base_url;
        }
    },
    props: {
        lawyers: {default: null},
        specializations: {default: null},
        prop_breadcrumbs: {default:null}
    },
    created() {
        console.log("Адвокаты");
        console.log(this.lawyers);
        console.log(this.specializations);
        this.specializations.forEach((specialization) => {
            if (specialization.selected) {
                this.selected_specializations.push(specialization.id);
            }
        });
        this.breadcrumbs = this.prop_breadcrumbs;
    }
}
</script>

<style scoped>
.hr-theme-slash-2 {
    display: flex;
}

.hr-line {
    width: 100%;
    position: relative;
    margin: 15px;
    border-bottom: 1px solid #000;
}

.hr-icon {
    position: relative;
    top: 3px;
    color: #ff0000;
}

.my_padding_for_card_text {
    padding: 20px 10px !important;
}
</style>
