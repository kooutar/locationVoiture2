// Toggle sidebar visibility on mobile
document.getElementById("menuButton").addEventListener("click", () => {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("-translate-x-full");
  
    // Toggle the 'hidden' class based on the sidebar visibility
    if (sidebar.classList.contains("-translate-x-full")) {
      sidebar.classList.add("hidden");
    } else {
      sidebar.classList.remove("hidden");
    }
  });
  
  // Revenue Flow Chart
  const revenueCtx = document.getElementById("revenueFlowChart").getContext("2d");
  new Chart(revenueCtx, {
    type: "bar",
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      datasets: [
        {
          label: "Revenue ($)",
          data: [3000, 4000, 3500, 5000, 7000, 6000, 8000],
          backgroundColor: "rgba(20, 184, 166, 0.6)",
          borderColor: "rgba(255, 255, 255, 0.8)",
          borderWidth: 2,
          borderRadius: 10,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, ticks: { color: "#e5e7eb" } },
        x: { ticks: { color: "#e5e7eb" } },
      },
      plugins: { legend: { labels: { color: "#e5e7eb" } } },
    },
  });
  
  // Available Balance Pie Chart
  const balanceCtx = document
    .getElementById("availableBalanceChart")
    .getContext("2d");
  new Chart(balanceCtx, {
    type: "pie",
    data: {
      datasets: [
        {
          data: [3500, 5000],
          backgroundColor: ["#1f2937", "#14b8a6"],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: { legend: { labels: { color: "#e5e7eb" } } },
    },
  });