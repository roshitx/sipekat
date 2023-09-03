import "./bootstrap";

import Alpine from "alpinejs";
import { createIcons, icons } from "lucide";
import "flowbite";
import Chart from "chart.js/auto";

window.Alpine = Alpine;

Alpine.start();
createIcons({ icons });

// Ambil data gender dari backend dengan Ajax
fetch("/gender-chart") // Ganti dengan URL endpoint yang sesuai
    .then((response) => response.json())
    .then((data) => {
        // Data gender dari server
        const genderData = data;

        // Membuat chart
        const ctx = document.getElementById("genderChart").getContext("2d");
        const genderChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Pria", "Wanita", "Lainnya"],
                datasets: [
                    {
                        data: [
                            genderData.pria,
                            genderData.wanita,
                            genderData.lainnya,
                        ],
                        backgroundColor: ["#3b82f6", "#ec4899", "#22c55e"],
                    },
                ],
            },
        });
    })
    .catch((error) => {
        console.error("Error fetching gender data:", error);
    });


    // Ambil data gender dari backend dengan Ajax
fetch("/gender-chart-petugas") // Ganti dengan URL endpoint yang sesuai
.then((response) => response.json())
.then((data) => {
    // Data gender dari server
    const genderData = data;

    // Membuat chart
    const ctx = document.getElementById("genderChartPetugas").getContext("2d");
    const genderChart = new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Pria", "Wanita", "Lainnya"],
            datasets: [
                {
                    data: [
                        genderData.pria,
                        genderData.wanita,
                        genderData.lainnya,
                    ],
                    backgroundColor: ["#3b82f6", "#ec4899", "#22c55e"],
                },
            ],
        },
    });
})
.catch((error) => {
    console.error("Error fetching gender data:", error);
});


// Ambil data rata-rata aduan per bulan dari backend dengan Ajax
fetch("/get-monthly-complaints-data")
    .then((response) => response.json())
    .then((data) => {
        // Data rata-rata aduan per bulan dari server
        const monthlyComplaintsData = data;

        // Membuat chart rata-rata aduan per bulan
        const ctx = document
            .getElementById("monthlyComplaintsChart")
            .getContext("2d");
        const monthlyComplaintsChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: monthlyComplaintsData.map((item) => item.month),
                datasets: [
                    {
                        label: "Aduan",
                        data: monthlyComplaintsData.map((item) => item.total),
                        backgroundColor: "#3490dc",
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    })
    .catch((error) => {
        console.error("Error fetching monthly complaints data:", error);
    });
