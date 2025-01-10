<?php
include('authentication.php');
include('middleware/admin_auth.php');
include('includes/header.php');
include('dashboard_fetching.php'); // Fetching data for cards and charts

// Fetch campaign data for charts
$query = "SELECT title AS campaign_name, raised, goal FROM campaigns";
$query_run = mysqli_query($con, $query);

$campaign_names = [];
$raised_amounts = [];
$goal_amounts = [];
$total_donations_per_campaign = [];

if ($query_run) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $campaign_names[] = $row['campaign_name'];
        $raised_amounts[] = $row['raised'];
        $goal_amounts[] = $row['goal'];

        // Fetch total donations for each campaign
        $donation_query = "SELECT COUNT(donations.id) AS total_donations 
                           FROM donations 
                           JOIN campaigns ON donations.campaign_id = campaigns.id 
                           WHERE campaigns.title = '" . mysqli_real_escape_string($con, $row['campaign_name']) . "'";
        $donation_result = mysqli_query($con, $donation_query);
        $donation_data = mysqli_fetch_assoc($donation_result);
        $total_donations_per_campaign[] = $donation_data['total_donations'] ?? 0;
    }
}

// Fetch donor data for Donors per Campaign chart
$donor_query = "SELECT campaigns.title AS campaign_name, COUNT(donations.id) AS total_donors 
                FROM donations 
                JOIN campaigns ON donations.campaign_id = campaigns.id 
                GROUP BY campaigns.title";
$donor_query_run = mysqli_query($con, $donor_query);

$donors_campaign_names = [];
$total_donors_per_campaign = [];

if ($donor_query_run) {
    while ($row = mysqli_fetch_assoc($donor_query_run)) {
        $donors_campaign_names[] = $row['campaign_name'];
        $total_donors_per_campaign[] = $row['total_donors'];
    }
}

// Fetch demographic data for chart
$demographic_query = "SELECT CONCAT(province, ', ', district) AS location, COUNT(*) AS donor_count 
                      FROM donations 
                      GROUP BY province, district";
$demographic_result = mysqli_query($con, $demographic_query);

$demographic_labels = [];
$demographic_data = [];
$demographic_colors = [];
$color_palette = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']; // Custom colors
$color_index = 0;

if ($demographic_result && mysqli_num_rows($demographic_result) > 0) {
    while ($row = mysqli_fetch_assoc($demographic_result)) {
        $demographic_labels[] = $row['location'];
        $demographic_data[] = $row['donor_count'];
        $demographic_colors[] = $color_palette[$color_index % count($color_palette)];
        $color_index++;
    }
}
?>

<style>
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .card {
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .charts {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Two charts side by side */
        gap: 20px;
        align-items: stretch;
    }

    .chart-container {
        background: #fff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .chart {
        width: 100%;
        height: 250px;
    }

    .chart-container canvas {
        max-width: 95%;
    }
</style>

<div class="container-fluid px-4">

    <h1 class="mt-4">Dashboard</h1>

    <?php include('../message.php'); ?>

    <div class="dashboard-cards">
        <!-- Total Donors -->
        <div class="card">
            <i class="fas fa-user"></i>
            <h5>Total Donors</h5>
            <p><?= $total_donors; ?></p>
        </div>
        <!-- Total Donations -->
        <div class="card">
            <i class="fas fa-donate"></i>
            <h5>Total Donations</h5>
            <p><?= $total_donations; ?></p>
        </div>
        <!-- Total Campaigns -->
        <div class="card">
            <i class="fas fa-flag"></i>
            <h5>Total Campaigns</h5>
            <p><?= $total_campaigns; ?></p>
        </div>
        <!-- Total Raised -->
        <div class="card">
            <i class="fas fa-hand-holding-usd"></i>
            <h5>Total Raised</h5>
            <p>LKR <?= number_format($total_raised, 2); ?></p>
        </div>
    </div>

    <div class="charts">
        <!-- Donors Per Campaign -->
        <div class="chart-container">
            <canvas id="donorsPerCampaignChart" class="chart"></canvas>
        </div>
        <!-- Raised vs Goal -->
        <div class="chart-container">
            <canvas id="raisedVsGoalChart" class="chart"></canvas>
        </div>
        <!-- Donations Per Campaign -->
        <div class="chart-container">
            <canvas id="donationsPerCampaignChart" class="chart"></canvas>
        </div>
        <!-- Demographic Chart -->
        <div class="chart-container">
            <canvas id="demographicChart" class="chart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Donations Per Campaign Chart
    const donationsPerCampaignCtx = document.getElementById('donationsPerCampaignChart').getContext('2d');
    new Chart(donationsPerCampaignCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($campaign_names); ?>,
            datasets: [{
                label: 'Total Donations',
                data: <?= json_encode($total_donations_per_campaign); ?>,
                backgroundColor: 'rgba(8, 57, 89, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Maintains a fixed aspect ratio
            aspectRatio: 2, // Sets a specific aspect ratio
            scales: {
                x: {
                    ticks: {
                        display: false // Hides X-axis labels
                    },
                    grid: {
                        display: false // Optional: Hides X-axis gridlines
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Donations'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                },
                title: {
                    display: true, // Enable the chart title
                    text: 'Donations Per Campaign', // Set the title text
                    font: {
                        size: 18, // Adjusted font size
                        weight: '500', // Set to bold for emphasis
                        family: 'Arial, sans-serif' // Custom font family
                    },
                    color: '#000000', // Set title text color (e.g., Indigo)
                    padding: {
                        top: 20,
                        bottom: 30 // Adjust padding for better spacing
                    },
                    align: 'center' // Align the title in the center
                }
            },
            elements: {
                bar: {
                    maxBarThickness: 10 // Reduces the bar width
                }
            }
        }
    });

    // Demographic Chart
    const demographicCtx = document.getElementById('demographicChart').getContext('2d');
    const demographicChart = new Chart(demographicCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($demographic_labels); ?>, // Province-level labels
            datasets: [{
                data: <?= json_encode($demographic_data); ?>, // Donor counts
                backgroundColor: <?= json_encode($demographic_colors); ?>, // Dynamic colors
                borderColor: '#FFFFFF', // Add a white border for better contrast on segments
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Maintain a fixed aspect ratio
            aspectRatio: 2, // Set a specific aspect ratio
            plugins: {
                legend: {
                    display: true, // Enable the legend
                    position: 'bottom', // Position the legend below the chart
                    labels: {
                        boxWidth: 30, // Rectangle box width
                        boxHeight: 15, // Rectangle box height
                        usePointStyle: false, // Ensures rectangles instead of circles
                        padding: 15, // Increase gap between legend items
                        font: {
                            size: 0 // Hide the text in the legend
                        },
                        generateLabels: function(chart) {
                            // Custom function to add hover behavior for legend tooltips
                            const data = chart.data;
                            return data.labels.map((label, index) => ({
                                text: '', // Keep legend text empty
                                fillStyle: data.datasets[0].backgroundColor[index],
                                hidden: false,
                                index: index
                            }));
                        }
                    },
                    onHover: function(event, legendItem) {
                        // Trigger hover event on the corresponding chart segment
                        const chart = event.chart;
                        const index = legendItem.index;
                        chart.setActiveElements([{
                            datasetIndex: 0,
                            index: index
                        }]);
                        chart.tooltip.setActiveElements([{
                            datasetIndex: 0,
                            index: index
                        }], {
                            x: event.x,
                            y: event.y
                        });
                        chart.update();
                    },
                    onLeave: function(event, legendItem) {
                        // Reset hover state when leaving the legend
                        const chart = event.chart;
                        chart.setActiveElements([]);
                        chart.tooltip.setActiveElements([]);
                        chart.update();
                    }
                },
                tooltip: {
                    enabled: true, // Enable tooltips
                    callbacks: {
                        label: function(context) {
                            const province = context.label; // Get the province name
                            const donorCount = context.raw; // Get the donor count
                            return `${province}: ${donorCount} donors`; // Tooltip text
                        }
                    }
                },
                title: {
                    display: true, // Enable the chart title
                    text: 'Donors Demographic by Province', // Set the title text
                    font: {
                        size: 18, // Adjusted font size
                        weight: '500', // Medium weight
                        family: 'Arial, sans-serif' // Custom font family
                    },
                    color: '#000000', // Title text color
                    padding: {
                        top: 20,
                        bottom: 30 // Adjust padding for better spacing
                    },
                    align: 'center' // Align the title in the center
                }
            }
        }
    });

    // Donors Per Campaign Chart
    const donorsPerCampaignCtx = document.getElementById('donorsPerCampaignChart').getContext('2d');
    new Chart(donorsPerCampaignCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($donors_campaign_names); ?>,
            datasets: [{
                label: 'Total Donors',
                data: <?= json_encode($total_donors_per_campaign); ?>,
                backgroundColor: 'rgba(239, 175, 13, 0.7)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Maintains a fixed aspect ratio
            aspectRatio: 2, // Sets a specific aspect ratio
            scales: {
                x: {
                    ticks: {
                        display: false // Hides X-axis labels
                    },
                    grid: {
                        display: false // Optional: Hides X-axis gridlines
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Donors'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                },
                title: {
                    display: true, // Enable the chart title
                    text: 'Donors Per Campaign', // Set the title text
                    font: {
                        size: 18, // Adjusted font size
                        weight: '500', // Set to bold for emphasis
                        family: 'Arial, sans-serif' // Custom font family
                    },
                    color: '#000000', // Set title text color (e.g., Indigo)
                    padding: {
                        top: 20,
                        bottom: 30 // Adjust padding for better spacing
                    },
                    align: 'center' // Align the title in the center
                }
            },
            elements: {
                bar: {
                    maxBarThickness: 10 // Reduces the bar width
                }
            }

        }
    });

    // Raised vs Goal Chart
    const raisedVsGoalCtx = document.getElementById('raisedVsGoalChart').getContext('2d');
    new Chart(raisedVsGoalCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($campaign_names); ?>,
            datasets: [{
                label: 'Raised',
                data: <?= json_encode($raised_amounts); ?>,
                borderColor: '#97a6c4',
                fill: false,
                tension: 0.4 // Adds smooth curves
            }, {
                label: 'Goal',
                data: <?= json_encode($goal_amounts); ?>,
                borderColor: '#384860',
                fill: false,
                tension: 0.4 // Adds smooth curves
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Maintains a fixed aspect ratio
            aspectRatio: 2, // Sets a specific aspect ratio
            scales: {
                x: {
                    ticks: {
                        display: false // Hides X-axis labels
                    },
                    grid: {
                        display: false // Optional: Hides X-axis gridlines
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (LKR)'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                },
                title: {
                    display: true, // Enable the chart title
                    text: 'Raised vs Goal', // Set the title text
                    font: {
                        size: 18, // Adjusted font size
                        weight: '500', // Set to bold for emphasis
                        family: 'Arial, sans-serif' // Custom font family
                    },
                    color: '#000000', // Set title text color (e.g., Indigo)
                    padding: {
                        top: 20,
                        bottom: 30 // Adjust padding for better spacing
                    },
                    align: 'center' // Align the title in the center
                }
            }
        }
    });
</script>


<?php include('includes/footer.php'); ?>