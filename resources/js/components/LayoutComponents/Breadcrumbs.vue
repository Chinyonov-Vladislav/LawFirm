<template>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center">
            <template v-for="(breadcrumb,index) in breadcrumbs">
                <li class="breadcrumb-item" v-if="index !== breadcrumbs.length-1">
                    <a class="color_link_in_breadcrumb" :href="breadcrumb.link">{{breadcrumb.text}}</a>
                </li>
                <li class="breadcrumb-item active" v-else>{{breadcrumb.text}}
                </li>
            </template>
        </ol>
    </nav>
</template>

<script>
export default {
    name: "Breadcrumbs",
    data() {
        return {
            breadcrumbs: [],
        };
    },
    methods:{
        goToPage(page) {
            // Здесь вы можете добавить логику для перехода на страницу
            // Например, можете использовать window.location.href или другие методы
            console.log(`Переход на страницу: ${page}`);
        },
    },
    props:{
        prop_breadcrumbs: []
    },
    created()
    {
        this.breadcrumbs = this.prop_breadcrumbs;
    }
}
</script>

<style scoped>

</style>
