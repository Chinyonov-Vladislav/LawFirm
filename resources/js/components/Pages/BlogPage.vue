<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title mt-blog-title text-center" style="margin-bottom: 30px">
            <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
            <h2>Новости <span>юриспруденции</span></h2>
        </div>
        <div class="blog-area" style="padding-bottom:50px; padding-top:25px;">
            <div class="container" v-if="all_count_news>0">
                <div class="row d-flex justify-content-center align-items-center" style="padding-bottom:25px">
                    <div class="col-8">
                        <div class="search">
                            <i class="fa fa-search"></i>
                            <input id="searchTextNews" type="text" class="form-control" placeholder="Поиск новостей"
                                   v-model="search.searchText">
                            <button class="btn btn-primary" @click="clickSearch">Поиск</button>
                        </div>
                    </div>
                    <div class="col-8 mt-1">
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox"
                                       :value="search.searchOptions.option1"
                                       v-model="search.searchOptions.option1"
                                       id="optionSearch1">
                                <label class="form-check-label" for="optionSearch1">
                                    Поиск в заголовке
                                </label>
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox"
                                       :value="search.searchOptions.option2"
                                       v-model="search.searchOptions.option2"
                                       id="optionSearch2">
                                <label class="form-check-label" for="optionSearch2">
                                    Поиск в описании
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if="news.length>0">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 mb-5" v-for="item in paginatedNews" :key="item.id">
                            <div class="blog-card h-100 d-flex flex-column">
                                <img :src="item.images[0]" alt="Image" class="card-img-top img_height my_image"
                                     v-if="item.images.length>0">
                                <img src="/photos/News.jpg" alt="Image" class="card-img-top img_height my_image" v-else>
                                <div class="blog-card-text d-flex flex-column">
                                    <h3><a href="#">{{ item.title }}</a></h3>
                                    <ul>
                                        <li>
                                            <i class="las la-calendar"></i>
                                            {{ formatDate(item.created_at) }}
                                        </li>
                                        <li>
                                            <i class="las la-user-alt"></i>
                                            {{ item.lawyer.second_name }} {{ item.lawyer.first_name }}
                                            {{ item.lawyer.middle_name }}
                                        </li>
                                    </ul>
                                    <p class="short_text">{{ item.description }}</p>
                                </div>
                                <div class="blog-card-text mt-auto">
                                    <a :href="'/news/'+item.id" class="read-more">
                                        Читать полностью <i class="las la-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <pagination
                        @handlePaginateData="handlePaginateData"
                        :array="news"
                        :maxVisiblePages="maxVisiblePages"
                        :itemsOnPage="itemsOnPage"
                        :namePagination="'news'"
                    ></pagination>
                </template>
                <template v-else>
                    <div class="row">
                        <h3 class="text-center">Новостей по запросу "{{search.searchText}}" не найдено</h3>
                    </div>
                </template>
            </div>
            <div class="container" v-else>
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">Новости отсутствуют</h1>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import moment from 'moment';
import Swal from "sweetalert2";

export default {
    name: "BlogPage",
    methods: {
        handlePaginateData(data) {
            if (data.namePagination === 'news') {
                this.paginatedNews = data.itemsForPage;
            }
        },
        formatDate(str_date) {
            return moment(str_date).format("DD-MM-YYYY")
        },
        showSwal(icon, title_text) {
            return Swal.fire({
                position: 'top-end',
                icon: icon,
                title: title_text,
                showConfirmButton: false,
                timer: 1500
            })
        },
        clickSearch() {
            if (this.search.searchText.length <= 0) {
                this.showSwal("error", "Вы не ввели запрос для поиска!");
            } else {
                if (this.search.searchOptions.option1 || this.search.searchOptions.option2) {
                    let base_url = '/blog?'
                    let queryParams = {
                        searchText: this.search.searchText,
                        option1: this.search.searchOptions.option1,
                        option2: this.search.searchOptions.option2,
                    }
                    let queryString = Object.keys(queryParams).map((key) => {
                        return `${key}=${queryParams[key]}`
                    }).join("&");
                    base_url += queryString;
                    window.location.href = base_url;
                } else {
                    this.showSwal("error", "Вы не выбрали параметры поиска!");
                }
            }
        },
    },
    props: {
        news: {default: []},
        prop_breadcrumbs: {default: null},
        prop_all_count_news: {default: 0}
    },
    data() {
        return {
            itemsOnPage: 6,
            currentPage: 1,
            maxVisiblePages: 3,
            paginatedNews: [],
            breadcrumbs: null,
            all_count_news: {default: 0},
            search: {
                searchText: "",
                searchOptions: {
                    option1: {default: false},
                    option2: {default: false}
                }
            }
        }
    },
    created() {
        console.log("Новости!");
        console.log(this.news);
        this.all_count_news = this.prop_all_count_news;
        this.breadcrumbs = this.prop_breadcrumbs;
        try {
            console.log("Значение option1");
            console.log(new URLSearchParams(window.location.search).get('option1'));
            this.search.searchOptions.option1 = new URLSearchParams(window.location.search).get('option1') === 'true';
        } catch (e) {
            console.log(e);
        }
        try {
            console.log("Значение option2");
            console.log(new URLSearchParams(window.location.search).get('option2'));
            this.search.searchOptions.option2 =new URLSearchParams(window.location.search).get('option2') === 'true';
        } catch (e) {
            console.log(e);
        }
        try {
            this.search.searchText = new URLSearchParams(window.location.search).get('searchText') || "";
        } catch (e) {
            console.log(e);
        }

    }

}
</script>

<style scoped>



</style>
