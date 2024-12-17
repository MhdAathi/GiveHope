<?php
include('authentication.php');
include('middleware\admin_auth.php');
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

        // Calculate donations for each campaign
        $campaign_id_query = "SELECT id FROM campaigns WHERE title='" . mysqli_real_escape_string($con, $row['campaign_name']) . "'";
        $campaign_id_result = mysqli_query($con, $campaign_id_query);
        $campaign_id_row = mysqli_fetch_assoc($campaign_id_result);
        $campaign_id = $campaign_id_row['id'];

        $donation_query = "SELECT COUNT(*) AS total_donations FROM donations WHERE campaign_id = '$campaign_id'";
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

    .card h5 {
        font-size: 14px;
        margin-top: 8px;
    }

    .card p {
        font-size: 18px;
        font-weight: bold;
    }

    .charts {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Ensures two charts per row */
        gap: 20px;
        /* Adds spacing between charts */
        align-items: stretch;
        /* Ensures all charts align properly */
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

    .chart-container h4 {
        font-size: 14px;
        margin-bottom: 8px;
        color: #333;
    }

    .chart {
        width: 100%;
        height: 250px;
        /* Smaller height for compact layout */
    }

    .chart-container canvas {
        max-width: 95%;
        /* Reduce chart canvas width slightly for breathing space */
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
            <h4>Donors Per Campaign</h4>
            <canvas id="donorsPerCampaignChart" class="chart"></canvas>
        </div>
        <!-- Raised vs Goal -->
        <div class="chart-container">
            <h4>Raised vs Goal</h4>
            <canvas id="raisedVsGoalChart" class="chart"></canvas>
        </div>
        <!-- Donations Per Campaign -->
        <div class="chart-container" style="grid-column: span 2;">
            <h4>Donations Per Campaign</h4>
            <canvas id="donationsPerCampaignChart" class="chart"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Bar Chart: Donations Per Campaign
    const donationsPerCampaignCtx = document.getElementById('donationsPerCampaignChart').getContext('2d');
    new Chart(donationsPerCampaignCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($campaign_names); ?>, // Keep the labels for tooltips
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
            aspectRatio: 4, // Sets a specific aspect ratio
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
                    display: false // Hides legend for compact view
                },
                tooltip: {
                    enabled: true // Ensures tooltips remain active
                }
            },
            elements: {
                bar: {
                    maxBarThickness: 10 // Reduces the bar width
                }
            }
        }
    });

    // Bar Chart: Donors Per Campaign
    const donorsPerCampaignCtx = document.getElementById('donorsPerCampaignChart').getContext('2d');
    new Chart(donorsPerCampaignCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($donors_campaign_names); ?>, // Keep the labels for tooltips
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
                }
            },
            elements: {
                bar: {
                    maxBarThickness: 10 // Reduces the bar width
                }
            }
        }
    });

    // Line Chart: Raised vs Goal
    const raisedVsGoalCtx = document.getElementById('raisedVsGoalChart').getContext('2d');
    new Chart(raisedVsGoalCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($campaign_names); ?>, // Keep the labels for tooltips
            datasets: [{
                    label: 'Raised',
                    data: <?= json_encode($raised_amounts); ?>,
                    borderColor: '#97a6c4',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Goal',
                    data: <?= json_encode($goal_amounts); ?>,
                    borderColor: '#384860',
                    fill: false,
                    tension: 0.4
                }
            ]
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
                }
            }
        }
    });
</script>

<?php include('includes/footer.php'); ?>