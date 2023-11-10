<template>
    <div class="d-flex row">
        <h3 class="text-center">{{title}}</h3>
        <div class="col-12">
            <Pie
                :chart-options="chartOptions"
                :chart-data="dataChart"
                :chart-id="chartId"
                :dataset-id-key="datasetIdKey"
                :css-classes="cssClasses"
                :styles="styles"
                :width="width"
                :height="height"
            />
        </div>
    </div>
</template>

<script>
import { Pie } from 'vue-chartjs/legacy'

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)
export default {
    name: "MyChart",
    components: {
        Pie
    },
    props: {
        chartId: {
            type: String,
            default: 'pie-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        dataChart: {default:null},
        title: {default:null}
    },
    data() {
        return {
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    }
}

</script>

<style scoped>

</style>
