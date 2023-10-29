<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title" style="margin-top: 150px; margin-bottom: 30px">
            <h2>Новости <span>юриспруденции</span></h2>
        </div>
        <div class="blog-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 mb-5" v-for="item in paginatedData" :key="item.id">
                        <div class="blog-card h-100 d-flex flex-column">
                            <img :src="item.Images[0]"  alt="Image" class="card-img-top my_image" v-if="item.Images.length>0">
                            <img src="/photos/News.jpg" alt="Image" class="card-img-top my_image" v-else>
                            <div class="blog-card-text d-flex flex-column">
                                <h3><a href="#">{{ item.Title }}</a></h3>
                                <ul>
                                    <li>
                                        <i class="las la-calendar"></i>
                                        22 Sep 2021
                                    </li>
                                    <li>
                                        <i class="las la-user-alt"></i>
                                        Thomas Albeny
                                    </li>
                                </ul>
                                <p class="short_text">{{ item.Description }}</p>
                            </div>
                            <div class="blog-card-text mt-auto">
                                <a href="#" class="read-more">
                                    Читать полностью <i class="las la-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="col-lg-12 col-md-12">
                    <ul class="pagination">
                        <li class="page-item">
                            <button @click="previousPage"
                                    v-bind:class="{'disabled':currentPage === 1}"
                                    class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </button>
                        </li>
                        <li class="page-item"
                            v-for="pageNumber in visiblePageNumbers"
                            v-bind:class="{'active': pageNumber===currentPage}">
                            <button
                                :key="pageNumber"
                                @click="goToPage(pageNumber)"
                                class="page-link">{{ pageNumber }}
                            </button>
                        </li>
                        <li class="page-item">
                            <button @click="nextPage"
                                    v-bind:class="{'disabled':currentPage === totalPages}"
                                    class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
export default {
    name: "BlogPage",
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
        },
    },
    computed: {
        totalPages() {
            return Math.ceil(this.news.length / this.itemsOnPage);
        },
        paginatedData() {
            const startIndex = (this.currentPage - 1) * this.itemsOnPage;
            const endIndex = startIndex + this.itemsOnPage;
            return this.news.slice(startIndex, endIndex);
        },
        visiblePageNumbers() {
            const totalPages = this.totalPages;
            const currentPage = this.currentPage;
            const maxVisiblePages = this.maxVisiblePages;

            if (totalPages <= maxVisiblePages) {
                return Array.from({length: totalPages}, (_, index) => index + 1);
            } else {
                const half = Math.floor(maxVisiblePages / 2);
                let start = currentPage - half;
                let end = currentPage + half;

                if (start <= 0) {
                    start = 1;
                    end = maxVisiblePages;
                } else if (end > totalPages) {
                    start = totalPages - maxVisiblePages + 1;
                    end = totalPages;
                }

                return Array.from({length: end - start + 1}, (_, index) => start + index);
            }
        },
    },
    data() {
        return {
            itemsOnPage: 6,
            currentPage: 1,
            maxVisiblePages: 3,
            news: [
                {
                    "Title": "Новость 1",
                    "Description": "Текст wdadadadwa ",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 2",
                    "Description": "Текст dww wdwadwadwadwafawgag wagaawgwaa",
                    "Images": []
                },
                {
                    "Title": "Новость 3",
                    "Description": "Текст dwadwad wawdadwawa w afwaa fawfwagag",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
                {
                    "Title": "Новость 4",
                    "Description": "Текст dwadadawdw wawfafagwahaahaah",
                    "Images": ["/photos/logo.png"]
                },
            ],
        }
    }
}
</script>

<style scoped>
.short_text {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    line-height: 21px;
    max-height: 105px;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
}
.my_image{
    min-height: 200px;
    max-height: 200px;
    object-fit: contain;
}
</style>
