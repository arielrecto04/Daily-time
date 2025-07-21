<script setup>
import { AuthLayout } from '@/layouts';
import { BarChart, Pie, Line, Doughnut, PolarArea, Radar, Bubble } from '@/components/chart';
import { ref } from 'vue';

const chartData = ref({
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    datasets: [
        {
            label: 'My First dataset',
            backgroundColor: [
                '#89CFF0',
                '#FFCDD2',
                '#90EE90'
            ],
            data: [40, 20, 12, 39, 10, 40, 39, 40, 20, 12, 39, 10],
        }
    ]
})

const options = ref({
    responsive: true,
    plugins: {
        legend: {
            display: false, // Hiding legend for a cleaner look
        },
        title: {
            display: true,
            text: 'Chart.js Bar Chart',
        },
    },
})

</script>
<template>
    <AuthLayout>
        <div class="grid grid-cols-2 gap-5 h-[calc(100vh-10rem)]">
            <div class="w-full rounded-lg shadow-sm">
                <BarChart :data="chartData" :options="options" />
            </div>
            <div class="w-full rounded-lg shadow-sm">
                <Pie :data="chartData" :options="options" />
            </div>
            <div class="w-full rounded-lg shadow-sm">
                <Line :data="chartData" :options="options" />
            </div>
            <div class="w-full rounded-lg shadow-sm">
                <Doughnut :data="chartData" :options="options" />
            </div>
            <div class="w-full rounded-lg shadow-sm">
                <PolarArea :data="chartData" :options="options" />
            </div>
            <div class="w-full rounded-lg shadow-sm">
                <Radar :data="chartData" :options="options" />
            </div>
            <div class="w-full rounded-lg shadow-sm">
                <Bubble :data="chartData" :options="options" />
            </div>
        </div>
    </AuthLayout>
</template>
