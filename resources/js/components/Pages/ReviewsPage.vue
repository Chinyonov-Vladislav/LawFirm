<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title mt-reviews-title" style="margin-bottom: 30px">
            <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
            <h2><span>Отзывы</span> о нашей работе</h2>
        </div>
        <div class="container" v-if="reviews.length>0">
            <div class="row mb-4 mx-2">
                <div class="col-12 border border-danger rounded-3" style="padding: 20px">
                    <doughnut-chart :dataChart="chartData"
                                    :title="'Показатели нашей результативности в оценках клиентов'"
                                    :average_score_title="'Средняя оценка: '+Math.round(average_rating)+'/5'"
                    ></doughnut-chart>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mt-2"
                     v-for="(review,index) in paginatedReviews">

                    <div class="border border-danger rounded-3 card h-100 d-flex flex-column" style="padding: 20px;">
                        <div class="card-body">
                            <h3 class="text-center">{{ review.topic_request }}</h3>
                            <h3 class="text-center" v-if="review.client_full_name!==null">
                                {{ review.client_full_name }}</h3>
                            <p class="card-text" v-if="review.feedback_instance!==null">{{
                                    review.feedback_instance
                                }}</p>
                        </div>
                        <star-rating
                            class="justify-content-center mt-auto"
                            id="star_rating"
                            readOnly
                            v-model="review.rating_instance"></star-rating>
                    </div>
                </div>
                <pagination
                    @handlePaginateData="handlePaginateData"
                    :array="reviews"
                    :maxVisiblePages="maxVisiblePages"
                    :itemsOnPage="itemsOnPage"
                    :namePagination="'reviews'"
                ></pagination>
            </div>
        </div>
        <div class="container text-center" v-else>
            <h3>Наши пользователи пока не оставляли отзывы!</h3>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
    name: "ReviewsPage",
    components: {
        StarRating
    },
    data() {
        return {
            reviews: {default: null},
            average_rating: {default: null},
            scores: {default: null},
            chartData: {
                labels: [],
                datasets: [
                    {
                        backgroundColor: [],
                        data: []
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            },
            maxVisiblePages: 3,
            itemsOnPage: 6,
            paginatedReviews: [],
            breadcrumbs: {default: null}
        }
    },
    props: {
        prop_reviews: {default: null},
        prop_average_rating: {default: null},
        prop_scores: {default: null},
        prop_breadcrumbs: {default: null}
    },
    created() {
        this.reviews = this.prop_reviews;
        this.average_rating = this.prop_average_rating;
        this.scores = this.prop_scores;
        console.log(this.reviews);
        this.scores.forEach((score) => {
            this.chartData.labels.push(score.rating.toString());
            this.chartData.datasets[0].data.push(score.count);
            this.chartData.datasets[0].backgroundColor.push(this.getRandomColor());
        });
        this.breadcrumbs = this.prop_breadcrumbs;
    },
    methods: {
        handlePaginateData(data) {
            if (data.namePagination === 'reviews') {
                this.paginatedReviews = data.itemsForPage;
            }
        },
        getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
    }
}
</script>

<style scoped>

</style>
