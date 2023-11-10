<template>
    <ul class="pagination d-flex justify-content-center">
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
</template>

<script>
export default {
    name: "Pagination",
    data() {
        return {
            currentPage: 0
        }
    },
    created()
    {
        this.currentPage = 1;
        this.paginatedData();
    },
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
            this.paginatedData();
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
            this.paginatedData();
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.paginatedData();
        },
        goToSamePage()
        {
            this.paginatedData();
        },
        paginatedData() {
            const startIndex = (this.currentPage - 1) * this.itemsOnPage;
            const endIndex = startIndex + this.itemsOnPage;
            let part = this.array.slice(startIndex, endIndex);
            if (this.namePagination === "requests") {
                if (part.length < 5) {
                    while (part.length !== 5) {
                        part.push({id: null, topic: null});
                    }
                }
            }
            this.$emit("handlePaginateData", {
                itemsForPage: part,
                namePagination: this.namePagination
            });
        },
    },
    watch:{
        itemsOnPage: function (old_val, new_val) {
            if(old_val!==new_val)
            {
                this.currentPage = 1;
                this.paginatedData();
            }
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.array.length / this.itemsOnPage);
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
    props: {
        array: {default: null},
        maxVisiblePages: {default: null},
        itemsOnPage:{default: null},
        namePagination: {default:null}
    }
}
</script>

<style scoped>

</style>
