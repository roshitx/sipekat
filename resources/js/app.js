import "./bootstrap";

import Alpine from "alpinejs";
import { createIcons, icons } from "lucide";
import "flowbite";
import Chart from "chart.js/auto";

window.Alpine = Alpine;

Alpine.start();
createIcons({ icons });

// Memuat Chart.js (pastikan Anda sudah mengimpor library Chart.js)

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
