/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
//debt
export const barChart = (data) => {
  const months = []
  const debts = []
  const totals = []


  data.map(item => {
    months.push("Tháng " + item.month)
    debts.push(item.debt)
    totals.push(item.total)
  })

  const barConfig = {
    type: 'bar',
    data: {
      labels: months,
      datasets: [
        {
          label: 'Nợ công',
          backgroundColor: '#0694a2',
          // borderColor: window.chartColors.red,
          borderWidth: 1,
          data: debts,
        },
        {
          label: 'Tổng tiền',
          backgroundColor: '#7e3af2',
          // borderColor: window.chartColors.blue,
          borderWidth: 1,
          data: totals,
        },
      ],
    },
    options: {
      responsive: true,
      legend: {
        display: false,
      },
      scales: {
        yAxes: [{
          ticks: {
            callback: function (value, index, values) {
              return value.toLocaleString("vi-VN");
            }
          },
        }],
      },
      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          }
        }
      }
    },
  }

  const barsCtx = document.getElementById('bars')
  window.myBar = new Chart(barsCtx, barConfig)
}